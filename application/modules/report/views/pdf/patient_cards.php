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

//header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A4', 'footer' => true)
);
$pdf = $this->mdsreporter;

// Document constants
$pat_nam = 'Name in full: ';
$pat_pid = 'HIN: ';
//$bring = 'Bring this card with you on your next visit';
$bring = 'Bring this card with you on every visit to the hospital';
$dat = 'Date: ';
$form_title = 'Patient Slip';
$pat_sex = 'Sex: ';
$pat_dob = 'Date of birth: ';
$pat_age = 'Age: ';
$pat_civ = 'Civil status: ';
$pat_nic = 'NIC number: ';
$pat_rem = 'Remarks: ';
$pat_hos = 'Hospital: ';
$pat_add = 'Address: ';

$query="select * from patient where PID=$pid";
$result=$this->db->query($query);
$patient=$result->first_row();
if ($result->num_rows()) {

    $pat_nam_d = $patient->Personal_Title.' '.$patient->Full_Name_Registered; //returns the fullname
    $pat_hos_d = $hospital; //returns the default hospital
    $pat_sex_d = $patient->Gender;
    $pat_dob_d = $patient->DateOfBirth;
    $pat_civ_d = $patient->Personal_Civil_Status;
    $pat_nic_d = $patient->NIC;
    $pat_rem_d = $patient->Remarks;
    $pat_pid_d = Modules::run('patient/print_hin',$patient->HIN); // returns the ID
    $barcode = $patient->HIN;
    $pat_add_d = $patient->Address_Street . " " . $patient->Address_Street1 . " " . $patient->Address_Village . " " . $patient->Address_DSDivision. " " . $patient->Address_District;
}


function showData($x1, $y1, $pat_hos_d, $pat_nam, $pat_pid, $pat_nam_d, $pat_pid_d, $bring,$barcode,$pdf) {
    $pdf->SetAutoPagebreak(0);
    $pdf->SetFont('arial', 'BU', 10);
    $dy=10;

    $pdf->SetXY($x1, $y1 + 1*$dy);
    $pdf->MultiCell(0, 4, $pat_hos_d, 0, 1, 0);
    $pdf->SetFont('arial', 'B', 10);
    $pdf->SetXY($x1, $y1 + 2*$dy);
    $pdf->write(8, $pat_nam);
    $pdf->SetXY($x1, $y1 + 3*$dy);
    $pdf->write(8, $pat_pid);

    $pdf->SetFont('arial', '', 10);
    $x2 = $x1 + 25;
    $pdf->SetXY($x2 + 8, $y1 + 2*$dy);
    $pdf->write(6, $pat_nam_d);
    $pdf->SetXY($x2 + 10, $y1 + 3*$dy);
    $pdf->write(8, $pat_pid_d);

    $pdf->setBarcode($barcode,$x1+5,$y1+4*$dy);
    $pdf->SetXY($x1, $y1 + 5.5*$dy);
    $pdf->SetFont('arial', 'B', 8);
    $pdf->write(8, $bring);
    $pdf->SetXY($x1, $y1 + 6*$dy);

    $pdf->SetFont('akandynew', '', 8);
    $encode_data = iconv('UTF-8', 'windows-1252', '@r~hlt p#É@zn s$m ìtm @mm k`Dpw ß@gn eNn.');
    $pdf->write(8, $encode_data);

}

#.......................................................................................................................................
// Create fpdf object
$pdf->addPage();

$dx=$pdf->getPageWidth()-$pdf->GetStringWidth($pat_nam_d);
$dx-=20;
$dx/=2;
showData($dx,50, $pat_hos_d, $pat_nam, $pat_pid, $pat_nam_d, $pat_pid_d, $bring,$barcode,$pdf);
$pdf->Output($pat_pid_d . ' patient_cards.pdf', 'I');
