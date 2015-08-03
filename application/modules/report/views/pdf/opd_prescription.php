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



// Document constants
$dat = 'Date: ';
$form_title = 'Prescription';
$pat_nam = 'Patient Name: ';
$pat_sex = 'Sex: ';
$pat_dob = 'Date of birth: ';
$pat_age = 'Age: ';
$pat_civ = 'Civil status: ';
$pat_rel = 'Religion: ';
$pat_nic = 'NIC number: ';
$pat_rem = 'Remarks: ';
$pat_pid = 'Register No: ';
$pat_hos = 'Hospital: ';
$pat_add = 'Address: ';
$pat_vist_dat = "Visit Date:";
$pat_onset_dat = "OnSet Date:";
$pat_doctor = "Doctor:";
$pat_complaint = "Complaint:";
$pat_icd = "ICD:";
$pat_snomed = "SNOMED:";
$pat_rem = "Remarks:";
// Document variables (to be passed to the script) - defined here for testing




//$query = "select * from opd_visits as ov join patient as p on p.PID=ov.PID where OPDID=$opdId";
//$result = $this->db->query($query);
//$patient = $result->first_row();
//unset($query);
//unset($result);
//$query="SELECT
//  prescribe_items.PRS_ITEM_ID,
//  drugs.Name,
//  prescribe_items.Dosage,
//  prescribe_items.HowLong,
//  prescribe_items.Frequency,
//  prescribe_items.Quantity,
//  prescribe_items.Status
//FROM prescribe_items
//  JOIN opd_presciption ON opd_presciption.PRSID = prescribe_items.PRES_ID AND opd_presciption.OPDID = $opdId
//  JOIN drugs ON prescribe_items.DRGID = drugs.DRGID
//WHERE prescribe_items.Active = 1";
//$result = $this->db->query($query);
//$prescription = $result->result_array();
if ($patient) {
    $dat_d = date('d/m/Y');
    $pat_nam_d = $patient['Personal_Title'].' '.$patient['Full_Name_Registered']; //returns the fullname
    $pat_hos_d = $hospital; //returns the default hospital
    $pat_sex_d = $patient['Gender'];
    $pat_dob_d = $patient['DateOfBirth'];
    $this->load->helper('hdate');
    $pat_age_d = dob_to_age($pat_dob_d);
    $pat_civ_d = $patient['Personal_Civil_Status'];
    $pat_nic_d = $patient['NIC'];
    $pat_rem_d = $patient['Remarks'];
    $pat_pid_d = $patient['PID']; // returns the ID
    $barcode = $pat_pid_d;
    $pat_add_d = $patient['Address_Street'] . " " . $patient['Address_Street1'] . " " . $patient['Address_Village'] . " " . $patient['Address_DSDivision']. " " . $patient['Address_District'];
}

// Create fpdf object
header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A5', 'footer' => true)
);
$pdf = $this->mdsreporter;
// Add a new page to the document
$pdf->addPage();
// Set the x,y coordinates of the cursor
$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle($form_title);

// Reset font, color, and coordinates
$pdf->SetFont('courier', '', 8);
$pdf->SetTextColor(0, 0, 0);

// Write patient details - field names

$pdf->setDy(0);
$pdf->setDx(45);
$pdf->Ln();
$pdf->SetWidths(array(22,40,20,40));
$pdf->colRow(array($pat_nam, $pat_nam_d,$pat_pid, $pat_pid_d),false,8,4);
$pdf->colRow(array($pat_add, $pat_add_d,$pat_age, $pat_age_d),false,8,4);
$pdf->Ln();
$pdf->Image('images/rx.png',5,$pdf->GetY()-6.5,20,20);
$pdf->Ln();
$rows=10;
if ($prescribe_items_list) {
//    $pdf->writeSSubTitle('Prescription:');
    $w = array(130);
    $pdf->SetWidths($w);
    $pdf->bottomRow(array('','','',''),true);
//    $pdf->bottomRow(array('Name','Dosage','How Long'),true);
    foreach ($prescribe_items_list as $row) {
        $row=array($row['drug_name'].'     '.$row['Dosage'].'     '.$row['Frequency'].'     '.$row['HowLong']);
        $pdf->bottomRow($row ,false, 10, 8);
        $rows-=1;
    }
}


//$pdf->addCirtification();
// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d.'prescription', 'i');
?>
