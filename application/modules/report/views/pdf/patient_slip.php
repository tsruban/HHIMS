<?php

/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
<http: www.hhims.org/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> or write to:
Free Software  HHIMS
C/- Lunar Technologies (PVT) Ltd,
15B Fullerton Estate II,
Gamagoda, Kalutara, Sri Lanka
---------------------------------------------------------------------------------- 
Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org
Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com
URL: http: www.hhims.org
----------------------------------------------------------------------------------
*/


header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A4', 'footer' => true)
);
$pdf = $this->mdsreporter;

// Document constants
$date = 'Date';
$title = 'Patient  Slip';
$pat_name = 'Patient Name: ';
$pat_sex = 'Sex: ';
$pat_dob = 'Date of birth: ';
$pat_age = 'Age: ';
$pat_status = 'Civil status: ';
$pat_rel = 'Religion: ';
$pat_nic = 'NIC number: ';
$pat_rmarks = 'Remarks: ';
$pat_rnum = 'HIN: ';
$pat_hos = 'Hospital: ';
$pat_add = 'Address: ';
$pat_rem = 'Remarks: ';

$query = "select * from patient where PID=$pid";
$result = $this->db->query($query);

if ($result->num_rows()) {
    $patient = $result->first_row();
    $dat_d = date('d/m/Y');
    $pat_nam_d = $patient->Personal_Title . ' ' . $patient->Full_Name_Registered; //returns the fullname
    $pat_hos_d = $hospital; //returns the default hospital
    $pat_sex_d = $patient->Gender;
    $pat_dob_d = $patient->DateOfBirth;
    $this->load->helper('hdate');
    $pat_age_d = dob_to_age($pat_dob_d); //$patient->getAge(); //returns in format 23yrs 3mths
    $pat_civ_d = $patient->Personal_Civil_Status;
    $pat_nic_d = $patient->NIC;
    $pat_rem_d = $patient->Remarks;
    $pat_pid_d = Modules::run('patient/print_hin',$patient->HIN); // returns the ID
    $barcode = $patient->HIN;
    $pat_add_d = $patient->Address_Street . " " . $patient->Address_Street1 . " " . $patient->Address_Village . " "
        . $patient->Address_DSDivision . " " . $patient->Address_District;

} else {
    echo 'Oops some thing happened ! We are working to fix this ';
    exit;
}


// Add a new page to the document
$pdf->addPage();

// Print two cards on the left side of the page (A5 landscape)
//$pdf->showData(10,0,$patient,$headings) ;
//$pdf->setDy(0);
$pdf->writeTitle($pat_hos_d, 5, 'L');
$pdf->writeSubTitle($title, 12, true, 'L');
$pdf->setDy(0);
$pdf->Ln();
$pdf->writeField($pat_name, $pat_nam_d);
$pdf->writeField($pat_rnum, $pat_pid_d);
$pdf->writeField($pat_sex, $pat_sex_d);
$pdf->writeField($pat_dob, $pat_dob_d);
$pdf->writeField($pat_age, $pat_age_d);
$pdf->writeField($pat_status, $pat_civ_d);
$pdf->writeField($pat_nic, $pat_nic_d);
$pdf->writeField($pat_add, $pat_add_d);
$pdf->writeField($pat_rem, $pat_rem_d);
$pdf->horizontalLine(2);


//echo "BarcodeX=".$barcodeX;
//$barcode="P215432";
$barcodeX = $pdf->getPageWidth() - $pdf->getBarcodeWidth($barcode);
$pdf->setBarcode($barcode, $barcodeX + 10, 4);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d . ' patient_slip', 'i');
?>
