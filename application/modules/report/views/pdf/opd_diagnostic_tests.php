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



$query = "SELECT
  ov.*,
  p.*,
  CONCAT(u.Title,' ',u.FirstName) as Doctor
FROM opd_visits AS ov JOIN patient AS p
    ON p.PID = ov.PID
  JOIN user AS u
    ON ov.Doctor = u.UID
WHERE OPDID = $opdId";
$result = $this->db->query($query);
$patient = $result->first_row();

if ($patient) {
    $dat_d = date('d/m/Y');
    $pat_nam_d = $patient->Personal_Title . ' ' . $patient->Full_Name_Registered; //returns the fullname
    $pat_hos_d = $hospital; //returns the default hospital
    $pat_sex_d = $patient->Gender;
    $pat_dob_d = $patient->DateOfBirth;
    $this->load->helper('hdate');
    $pat_age_d = dob_to_age($pat_dob_d);
    $pat_civ_d = $patient->Personal_Civil_Status;
    $pat_nic_d = $patient->NIC;
    $pat_rem_d = $patient->Remarks;
    $pat_pid_d = Modules::run('patient/print_hin',$patient->HIN); // returns the ID
    $barcode = $pat_pid_d;
    $pat_add_d = $patient->Address_Street . " " . $patient->Address_Street1 . " " . $patient->Address_Village . " "
        . $patient->Address_DSDivision . " " . $patient->Address_District;
    $pat_visit_dat_d=$patient->DateTimeOfVisit;
    $pat_onset_dat_d=$patient->OnSetDate;
    $pat_complaint_d=$patient->Complaint;
    $pat_doctor_d=$patient->Doctor;
    $pat_icd_d=$patient->ICD_Code;
    $pat_snomed_d=$patient->SNOMED_Text;

}else{
    echo 'Patient not found !';
    return;
}

// Document constants
$dat = 'Date';
$form_title = 'Diagnostic Test Results';
$pat_nam = 'Name in full: ';
$pat_age = 'Age: ';
$pat_pid = 'HIN: ';
$pat_hos = 'Hospital: ';
$orderdate = 'Order date :';
$complaint = 'Complaints / Injuries:';
$pat_sex = 'Sex: ';
$pat_dob = 'Date of birth: ';
$pat_civ = 'Civil status: ';
$pat_nic = 'NIC number: ';
$pat_rem = 'Remarks: ';
$pat_pid = 'HIN: ';
$pat_add = 'Address: ';
$pat_rel = 'Religion: ';
$pat_visit_dat = "Visit Date:";
$pat_onset_dat = "OnSet Date:";
$pat_doctor = "Doctor:";
$pat_complaint = "Complaint:";
$pat_icd = "ICD:";
$pat_snomed = "SNOMED:";
$pat_rem = "Remarks:";


//..............................................................................................................................................
// Create fpdf object
header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A5', 'footer' => true)
);
$pdf = $this->mdsreporter;
// Add a new page to the document
$pdf->addPage();

$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle($form_title);


// Write patient details - field names
$dh = 2;
$fsize = 10;
$dy = 3;

$pdf->setDy(0);
$pdf->setDx(45);
$pdf->Ln();
$pdf->SetWidths(array(24, 40, 24, 40));
$pdf->colRow(array($pat_nam, $pat_nam_d, $pat_pid, $pat_pid_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_dob, $pat_dob_d, $pat_age, $pat_age_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_civ, $pat_civ_d, $pat_sex, $pat_sex_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_nic, $pat_nic_d, $pat_add, $pat_add_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_visit_dat, $pat_visit_dat_d, $pat_onset_dat, $pat_onset_dat_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_complaint, $pat_complaint_d, $pat_doctor, $pat_doctor_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_icd, $pat_icd_d, $pat_snomed, $pat_snomed_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_rem, $pat_rem_d, '', ''), FALSE, $fsize, $dy, $dh);
$pdf->horizontalLine();

// GETTING LAB ORDER DATA
unset($query);
unset($result);
$query
    = "SELECT LAB_ORDER_ID FROM lab_order WHERE (OBJID = '" . $opdId . "') AND (Dept = 'OPD') ORDER BY OrderDate DESC";
$result = $this->db->query($query);
$labOrdersIds=$result->result_array();
$header = array('Test', 'Result', 'Ref. Value');
$pdf->SetWidths(array(40, 40, 48));
$pdf->Ln();
$pdf->Row($header,true);
$pdf->SetFont('courier', '', 8);
foreach($labOrdersIds as $row)  {
    if ($row["LAB_ORDER_ID"]) {
        unset($query);
        unset($result);
        $query = "SELECT LAB_ORDER_ITEM_ID,LABID FROM lab_order_items WHERE LAB_ORDER_ID = '".$row['LAB_ORDER_ID']."'";
        $result=$this->db->query($query);
        $labOrderItems=$result->result_array();
        foreach($labOrderItems as $row1)  {
            if ($row1["LAB_ORDER_ITEM_ID"]) {
                unset($query);
                unset($result);
                $query="select * from lab_tests where LABID=".$row1['LABID'];
                $result=$this->db->query($query);
                $l_test = $result->first_row();
                unset($query);
                unset($result);
                $query="select * from lab_order_items where LAB_ORDER_ITEM_ID=".$row1['LAB_ORDER_ITEM_ID'];
                $result=$this->db->query($query);
                $l_item = $result->first_row();
                $row = array($l_test -> Name, $l_item->TestValue,str_replace('<br>', ',', $l_test->RefValue ));
                $pdf->Row($row);
            }
        }
    }
}


// $pdf->setBarcode($barcode);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d . '_diagnostic_tests.pdf', 'I');
?>