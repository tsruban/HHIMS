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


$query
    = "
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
WHERE ADMID =" . $adminId;
$result = $this->db->query($query);
$patient = $result->first_row();
//field values
$dat_d = date('d/m/Y');
$pat_hos_d = $hospital;
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
$pat_pid_d = Modules::run('patient/print_hin',$patient->HIN); // returns the ID
$pat_rem_d = $patient->Remarks;

$admin_date_d = $patient->AdmissionDate;
$admin_onsetdate_d = $patient->OnSetDate;
$admin_bht_d = $patient->BHT;
$admin_doctor_d = $patient->Doctor;
$admin_ward_d = $patient->Ward;
$admin_complaint_d = $patient->Complaint;
$admin_discharge_date_d = $patient->DischargeDate;
$admin_discharge_outcome_d = $patient->OutCome;
$admin_discharge_diag_d = $patient->Discharge_ICD_Text;
$admin_pag_d = $patient->ContactPerson; // 'Father, Mohamed Amila, Rideegama';
$admin_tel_d = $patient->Telephone;
$admin_discharge_diag_d = $patient->Discharge_ICD_Text;
$admin_discharge_rem_d = $patient->Discharge_Remarks;
//pdf decleration

header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A5', 'footer' => true)
);
$pdf = $this->mdsreporter;
$pdf->setFormNum('Health 946');
$pdf->AddPage();


//setup page title
$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle('Transfer of Patient from one Institute to Another');

//horizontal & vertical space
$pdf->setDx(25);
$pdf->setDy(5);


//write field names/values
$pdf->Ln();
$pdf->SetWidths(array(20, 105));
$pdf->bottomRowOdd(array('From:', $pat_hos_d), FALSE, 10, 8);
$pdf->bottomRowOdd(array('To:', $patient->ReferTo), FALSE, 10, 8);
$pdf->SetWidths(array(28, 39, 19, 39));
$pdf->bottomRowOdd(array('Bed Head No:', $admin_bht_d, 'Ward No:', $admin_ward_d), FALSE, 10, 8);
$pdf->SetWidths(array(28, 97));
$pdf->bottomRowOdd(array('Full Name:', $pat_nam_d . '( HIN: ' . $pat_pid_d . ')'), FALSE, 10, 8);
$pdf->bottomRowOdd(array('Address:', $pat_add_d), FALSE, 10, 8);
$pdf->SetWidths(array(15, 40, 15, 30));
$pdf->bottomRowOdd(array('Age:', $pat_age_d, 'Sex:', $pat_sex_d), FALSE, 10, 8);
$pdf->SetWidths(array(58, 67));
$pdf->bottomRowOdd(array('Name and Address of Gardian:', $patient->ContactPerson), FALSE, 10, 8);
$pdf->SetWidths(array(50, 75));
$pdf->bottomRowOdd(array('Discharge ICD Diagnosis:', $admin_discharge_diag_d), FALSE, 10, 8);
$pdf->SetWidths(array(25, 100));
$pdf->bottomRowOdd(array('Remarks:', $admin_discharge_rem_d), FALSE, 10, 8);

$pdf->addCirtification();
// Close the document and offer to show or save to ~/Downloads
$pdf->Output('transfer ADMID=' . $adminId, 'i');
?>
