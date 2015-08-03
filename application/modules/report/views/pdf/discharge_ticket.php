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
//echo $admission->displayFields();
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
$admin_discharge_immr_d = $patient->Discharge_IMMR_Text;


//pdf decleration
header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A5', 'footer' => true)
);
$pdf = $this->mdsreporter;
$pdf->setFormNum('Health 383A');
$pdf->AddPage();

//setup page title
$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle('Diagnosis Ticket');


//horizontal & vertical space
$pdf->setDx(50);
$pdf->setDy(0);


//write field names/values
$dy=4;
$dh=3;
$fontSize=10;
$pdf->Ln();
$pdf->SetWidths(array(40, 85));
$pdf->bottomRowOdd(array('Name of the Patient:', $pat_nam_d . '( HIN:  ' . $pat_pid_d . ')'),FALSE,$fontSize,$dy,$dh);
$pdf->SetWidths(array(20,40));
$pdf->bottomRowOdd(array('Age:', $pat_age_d),FALSE,$fontSize,$dy,$dh);
$pdf->SetWidths(array(15, 50, 30, 30));
$pdf->bottomRowOdd(array('Ward:', $admin_ward_d, 'Bed Head No:', $admin_bht_d),FALSE,$fontSize,$dy,$dh);
$pdf->SetWidths(array(35, 27, 35, 28));
$pdf->bottomRowOdd(array('Date of Admission:', mdsGetDate($admin_date_d), 'Date of Discharge:', mdsGetDate($admin_discharge_date_d)),FALSE,$fontSize,$dy,$dh);

$pdf->writeSSubTitle('Investigation and Treatment');
$pdf->Ln(2);
$pdf->SetWidths(array(40, 85));
$pdf->colRow(array('Admission Reason:', $patient->Complaint),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Admission Remarks:', $patient->Remarks),FALSE,$fontSize,$dy,$dh);
// $pdf->MultiCell(0, 2, '','B');
// $pdf->Ln(3);

unset($query);
unset($result);
$query = " SELECT * FROM admission_diagnosis WHERE ADMID = '" . $adminId. "' ORDER BY DiagnosisDate DESC ";
$result = $this->db->query($query);
$count = $result->num_rows();
if (!$result) {
    echo "ERROR getting Lab Items";
    return null;
}
$diag=1;
if ($count != 0) {
    $row = mysql_fetch_array($result->result_id);
    $pdf->colRow(array('Diagnosis:', $diag.'.'.$row["ICD_Text"]),FALSE,$fontSize,$dy,$dh);
    while ($row = mysql_fetch_array($result->result_id)) {
    	$diag++;
        $pdf->colRow(array('' ,$diag.'.'.$row["ICD_Text"]),FALSE,$fontSize,$dy,$dh);
    }

}


unset($query);
unset($result);
$query = " SELECT * FROM admission_procedures WHERE ADMID = '" . $adminId . "' ORDER BY ProcedureDate DESC ";
$result = $this->db->query($query);
$count = $result->num_rows();
if (!$result) {
    echo "ERROR getting Lab Items";
    return null;
}
if ($count != 0) {
//     $pdf->MultiCell(0, 1, '','B');
    $row = mysql_fetch_array($result->result_id);
//     $pdf->SetWidths(array(38, 87));
    $pdf->colRow(array('Surgical Procedure:', $row["SNOMED_Text"]),FALSE,$fontSize,$dy,$dh);
    while ($row = mysql_fetch_array($result->result_id)) {
        $pdf->colRow(array('', $row["SNOMED_Text"]),FALSE,$fontSize,$dy,$dh);
    }
    
//     $pdf->MultiCell(0, 1, '','B');
}
$pdf->SetWidths(array(40, 85));
$pdf->colRow(array('Discharge Diagnosis:', $admin_discharge_diag_d),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Discharge IMMR:', $admin_discharge_immr_d),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Outcome:', $admin_discharge_outcome_d),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Referred To:', $patient->ReferTo),FALSE,$fontSize,$dy,$dh);
$pdf->colRow(array('Discharge Remarks:', trim($admin_discharge_rem_d)),FALSE,$fontSize,$dy,$dh);

$pdf->addCirtification();

// Close the document and offer to show or save to ~/Downloads
$pdf->Output('discharge_ticket ADMID=' . $adminId, 'i');
?>
