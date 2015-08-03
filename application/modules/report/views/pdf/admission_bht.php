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


$query = "
SELECT
  ad.*,
  p.*,
  w.Name                            AS Ward,
  concat(u.Title, ' ', u.FirstName) AS Doctor
FROM admission AS ad JOIN patient AS p
    ON (ad.PID = p.PID)
  JOIN ward AS w
    ON ad.Ward = w.WID
  JOIN user AS u
    ON ad.Doctor = u.UID
WHERE ADMID =".$adminId;
$result = $this->db->query($query);
$patient = $result->first_row();

//revelution remove from production
//$patient=new MDSPatient();

$form_title = 'Bed Head Ticket';
$pat_hos = 'Hospital:';
$pat_pid = 'HIN:';
$pat_bht = 'BHT No:';
$pat_nam = 'Patient Name:';
$pat_nic = 'NIC Number:';
$pat_sex = 'Sex:';
$pat_age = 'Age:';
$pat_civ = 'Civil status:';
$pat_add = 'Address:';
$adm_war = 'Ward:';
$adm_dat = 'Date of admission:';
$adm_tim = 'Time of admission:';
$adm_ons = 'Date of onset dis/inj.:';
$adm_con = "Consultant's name:";
$adm_did = 'Date of discharge/death:';
$adm_art = 'Articles in possession:';
$adm_pag = 'Parent/guardian:';
$adm_tel = 'Telephone:';
$adm_com = 'Disease or injury:';
$dat = 'Date:';
$pre = 'History, symptoms, diagnosis, treatment';
$rem = 'Remarks';

// Document variables (to be passed to the script) - defined here for testing
$dat_d = date('d/m/Y');

$pat_hos_d = $hospital;
$pat_pid_d = Modules::run('patient/print_hin',$patient->HIN);

$pat_bht_d = $patient->BHT;
$pat_nam_d = $patient->Personal_Title . ' ' . $patient->Full_Name_Registered;
$pat_nic_d = $patient->NIC;
$pat_sex_d = $patient->Gender;
$pat_dob_d = $patient->DateOfBirth;
$this->load->helper('hdate');
$pat_age_d = dob_to_age($pat_dob_d);
$pat_civ_d = $patient->CStatus;
$pat_add_d = $patient->Address_Street . " " . $patient->Address_Village . " " . $patient->Address_DSDivision . " "
    . $patient->Address_District;

$adm_war_d = $patient->Ward;
$adm_dat_d = mdsGetDate($patient->AdmissionDate);
$adm_tim_d = mdsGetTime($patient->AdmissionDate);
$adm_ons_d = mdsGetDate($patient->DischargeDate);
$adm_con_d = $patient->Doctor;
$adm_did_d = '';
$adm_art_d = '';
$adm_pag_d = $patient->ContactPerson; // 'Father, Mohamed Amila, Rideegama';
$adm_tel_d = $patient->Telephone;
$adm_com_d = $patient->Complaint;

// Create fpdf object
header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A5', 'footer' => true)
);
$pdf = $this->mdsreporter;
$pdf->addPage();

//set gaps
$pdf->setDx(60);
$pdf->setDy(0);

$x = $pdf->GetX();
$y = $pdf->GetY();
$barcode = $adminId;
$barcodeX = $pdf->getPageWidth() - $pdf->getBarcodeWidth($barcode);
$pdf->setBarcode('A' . $barcode, $barcodeX + 5, 4);

$pdf->setXY($x, $y);
$pdf->writeTitle($pat_hos_d, 5, 'L');
$pdf->writeSubTitle($form_title, 12, true, 'L');


// Write patient details - field names
$pdf->Ln(4);
$dh = 1;
$fsize = 8;
$dy = 3;

$pdf->SetAligns(array('R', 'L', 'R', 'L'));
$pdf->SetWidths(array(30, 35, 35, 35));
$pdf->colRow(array($pat_nam, $pat_nam_d, $adm_war, $adm_war_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_pid, $pat_pid_d, $adm_dat, $adm_dat_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_bht, $pat_bht_d, $adm_tim, $adm_tim_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_age, $pat_age_d, $adm_ons, $adm_ons_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_sex, $pat_sex_d, $adm_com, $adm_com_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_civ, $pat_civ_d, $adm_con, $adm_con_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_nic, $pat_nic_d, $adm_did, $adm_did_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($adm_tel, $adm_tel_d, $adm_art, $adm_art_d), FALSE, $fsize, $dy, $dh);
$pdf->colRow(array($pat_add, mdsTrim($pat_add_d, 40), $adm_pag, mdsTrim($adm_pag_d, 40)), FALSE, $fsize, $dy, $dh);
$pdf->Ln();
$pdf->SetAligns(array('C'));
$pdf->SetWidths(array(130));
$pdf->Row(array($adm_com . ' ' . $adm_com_d), true);
$pdf->SetWidths(array(20, 75, 35));
$pdf->SetAligns(array('L', 'L', 'L'));
$pdf->Row(array('Date', $pre, $rem), true);
$nlines = 15;
for ($i = 1; $i < $nlines; $i++) {
    $pdf->Row(array('', '', ''));
}


// Close the document and offer to show or save to ~/Downloads
$pdf->Output($pat_pid_d . 'bht.pdf', 'I');
?>
