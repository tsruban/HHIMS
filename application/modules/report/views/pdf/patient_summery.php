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
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A5', 'footer' => true)
);
$pdf = $this->mdsreporter;

unset($result);
$sql = " SELECT * FROM patient_history WHERE ( PID = '" . $pid . "' )  AND (Active=1) ORDER BY HistoryDate DESC ";
$result = $this->db->query($sql);

if ($result->num_rows()) {
    $i = 0;
    while ($row = mysql_fetch_array($result->result_id)) {
        if ($row["PATHISTORYID"]) {
            $histry_JSON[$i] = array("Date"   => $row["HistoryDate"], "Type" => $row["History_Type"],
                                     "Snomed" => $row["SNOMED_Text"], "Remarks" => $row["Remarks"]);
            $i++;
        }
    }
}

unset($result);
$sql = "SELECT * FROM patient_alergy where ( PID ='" . $pid . "' ) AND (Active=1)  ORDER BY Name";
$result = $this->db->query($sql);

if ($result->num_rows()) {
    $i = 0;
    while ($row = mysql_fetch_array($result->result_id)) {
        if ($row["ALERGYID"]) {
            $allergy_JSON[$i] = array("Date"    => $row["CreateDate"], "Type" => $row["Name"],
                                      "Snomed"  => $row["Status"],
                                      "Remarks" => $row["Remarks"]);
            $i++;
        }
    }
}

unset($result);
$sql =
    "SELECT ov.DateTimeOfVisit,vt.Name as VisitType,ov.Complaint,ov.Remarks,ov.OPDID FROM opd_visits as ov JOIN visit_type as vt on ov.VisitType=vt.VTYPID  where PID ='"
    . $pid . "' ORDER BY ov.DateTimeOfVisit DESC;";
$result = $this->db->query($sql);

if ($result->num_rows) {
    $i = 0;
    while ($row = mysql_fetch_array($result->result_id)) {
        if ($row["OPDID"]) {

            $visit_JSON[$i] = array("Date"      => $row["DateTimeOfVisit"], "Type" => $row["VisitType"],
                                    "Complaint" => $row["Complaint"], "Remarks" => $row["Remarks"],
                                    "OPDID"     => $row["OPDID"]);
            $i++;
        }
    }
}

unset($result);
$sql = "SELECT * FROM admission where PID ='" . $pid . "' ORDER BY AdmissionDate DESC";
$result = $this->db->query($sql);

if ($result->num_rows) {
    $i = 0;
    while ($row = mysql_fetch_array($result->result_id)) {
        if ($row["ADMID"]) {

            $admission_JSON[$i] = array("Date"          => $row["AdmissionDate"], "Complaint" => $row["Complaint"],
                                        "Diagnosis"     => $row["Discharge_ICD_Text"], "Remarks" => $row["Remarks"],
                                        "DischargeDate" => $row["DischargeDate"], 'ADMID' => $row['ADMID']);
            $i++;
        }
    }
}


$form_tit = 'Patient Summary';
$form_tak = 'Take this card when you visit the doctor';
$form_patd = 'Personal details';
$pat_nam = 'Patient Name:';
$pat_pid = 'HIN:';
$pat_pidl = ' (';
$pat_pidr = ')';
$pat_age = 'Age:';
$pat_sex = 'Sex:';
$pat_civ = 'Civil status:';
$pat_nic = 'NIC:';
$pat_pho = 'Telephone:';
$pat_add = 'Address:';
$form_phis = 'Past history';
$form_dat = 'Date';
$form_scon = 'Snomed concept';
$form_rem = 'Remarks';
$form_ovc = 'OPD Visits and Clinics';
$form_com = 'Complaint';
$form_dru = 'Drugs/treatments: ';
$form_con = 'Consultant name:';
$form_padm = 'Previous admissions';
$form_adm = 'Last admission';
$pat_dad = 'Date of admission:';
$pat_ddi = 'Date of discharge:';
$pat_bht = 'BHT no.: ';
$pat_adr = 'Admission reason: ';
$pat_pcom = 'Presenting complaint: ';
$pat_wdi = 'Working diagnosis (ICD): ';
$pat_sdi = 'Working diagnosis (Snomed): ';
$pat_spr = 'Surgical procedures: ';
$pat_tre = 'Treatments given: ';
$pat_ddic = 'Discharge diagnosis (ICD): ';
$pat_ddim = 'Discharge diagnosis (IMMR): ';
$pat_out = 'Outcome: ';
$pat_ref = 'Referred to: ';
$form_dia = 'Diagnostic tests: ';
$form_sdo = 'Signature & designation: .......................................................';
$form_alerg = 'Allergies';
$form_visit = 'Visits';
$form_admission = 'Admissions';

$this->load->helper('hdate');

$query = "select * from patient where PID=$pid";
$result = $this->db->query($query);
$patient = $result->first_row();
if ($result->num_rows()) {

    $pat_nam_d = $patient->Personal_Title . ' ' . $patient->Full_Name_Registered; //returns the fullname
    $pat_hos_d = $hospital; //returns the default hospital
    $pat_sex_d = $patient->Gender;
    $pat_dob_d = $patient->DateOfBirth;
    $pat_civ_d = $patient->Personal_Civil_Status;
    $pat_nic_d = $patient->NIC;
    $pat_pho_d = $patient->Telephone;
    $pat_rem_d = $patient->Remarks;
    $pat_pid_d = Modules::run('patient/print_hin', $patient->HIN); // returns the ID
    $pat_age_d = dob_to_age($pat_dob_d);
    $barcode   = $pat_pid_d;
    $pat_add_d = $patient->Address_Street . " " . $patient->Address_Street1 . " " . $patient->Address_Village . " "
        . $patient->Address_DSDivision . " " . $patient->Address_District;
}
$pat_dad_d = '02/01/2011';
$pat_ddi_d = '07/01/2011';
$pat_bht_d = '124/124';
$pat_adr_d = 'Coughing blood';
$pat_pcom_d = 'Pale, emaciated, febrile';
$pat_wdi_d = 'A91 Dengue haemorrhagic fever';
$pat_sdi_d = 'DHF - Dengue';
$pat_spr_d = 'Diagnostic lumbar puncture';
$pat_tre_d = 'Intravenous fluids, Platelet transfusion';
$pat_ddic_d = 'A91 Dengue haemorrhagic fever';
$pat_ddim_d = '032 Dengue haemorrhagic fever';
$pat_out_d = 'Recovered, to be followed up';
$pat_ref_d = 'Dengue follow-up unit, Kurunegala';
$date = date('d/m/Y');

// for Past history, OPD visits and Diagnostic tests see separate files (array)
//.................................................................................................................................................................
$pdf->AddPage();


$pdf->writeTitle($pat_hos_d);
$pdf->writeSubTitle($form_tit, 12);
//$pdf->writeSubTitle($form_tak, 10);
//
//// Write patient details - field names . data
//$pdf->SetFont('', 'BU', 8);
$pdf->writeSSubTitle($form_patd);

$pdf->setDy(0);
$pdf->setDx(32);
$pdf->SetWidths(array(22, 40, 22, 40));
$pdf->SetAligns(array('L', 'L', 'L', 'L'));
$pdf->colRow(array($pat_nam, $pat_nam_d, $pat_pid, $pat_pid_d), false, 8, 4);
$pdf->colRow(array($pat_age, $pat_age_d, $pat_sex, $pat_sex_d), false, 8, 4);
$pdf->colRow(array($pat_civ, $pat_civ_d, $pat_nic, $pat_nic_d), false, 8, 4);
$pdf->writeField($pat_pho, $pat_pho_d, 8);
$pdf->writeField($pat_add, $pat_add_d, 8);
//$pdf->horizontalLine();
//write admition if exists

//write allergies if exists
if (isset($allergy_JSON)) {
    $pdf->Ln();
    $pdf->SetWidths(array(128));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_alerg), true);
    $pdf->SetWidths(array(28, 20, 40, 40));
    $pdf->Row(array('First Recorded', 'Status', 'Allergy', 'Remarks'), true);
    $pdf->SetFont('', '', 8);
    foreach ($allergy_JSON as $row) {
        $row = array(mdsGetDate($row['Date']), $row['Snomed'] ? $row['Snomed'] : '-', $row['Type'] ? $row['Type'] : '-',
                     $row['Remarks'] ? $row['Remarks'] : '-');
        $pdf->Row($row);
    }
}

//write histroy if exists
if (isset($histry_JSON)) {

    $pdf->Ln();
    $pdf->SetWidths(array(128));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_phis), true);

    $pdf->SetWidths(array(24, 52, 52));
    $pdf->Row(array('Period', 'Snomed concept', 'Remarks'), true);
    $pdf->SetFont('', '', 8);
    foreach ($histry_JSON as $row) {
        $row = array($row['Date'], $row['Snomed'] ? $row['Snomed'] : '-', $row['Remarks'] ? $row['Remarks'] : '-');
        $pdf->Row($row);
    }
}

// WRITE NOTES IF EXISTS
unset($result);
unset($row);
$sql="SELECT patient_notes.patient_notes_id ,
	SUBSTRING(patient_notes.CreateDate,1,10) as dte,
	patient_notes.notes,createuser
	FROM patient_notes
	where (patient_notes.PID ='" . $pid . "') and (patient_notes.Active = 1)";
$result = $this->db->query($sql);

if ($result->num_rows) {
    $pdf->Ln();
    $pdf->SetWidths(array(128));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array('Patient Nursing Notes'), true);

    $pdf->SetWidths(array(24, 52, 52));
    $pdf->Row(array('Note', 'Created Date', 'Created User'), true);
    $pdf->SetFont('', '', 8);

    $i = 0;
    while ($row = mysql_fetch_array($result->result_id)) {

        $row = array($row['notes'], $row['dte'] ,$row['createuser']);
        $pdf->Row($row);
    }
}



//write visit if exists
if (isset($visit_JSON)) {
$count = 0;
$pdf->Ln();
$pdf->SetWidths(array(128));

    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_visit . "(Shows only last 5 visits)"), true);

    $pdf->SetWidths(array(24, 24, 40, 40));
    $pdf->Row(array('Visit Date', 'Type of Visit', 'Complaint', 'Remarks'), true, 8);
    $pdf->SetFont('', '', 8);
    foreach ($visit_JSON as $row) {
        $count++;
        $notes= Modules::run('opd/get_nursing_notes',$row["OPDID"],'opd/view/'.$row["OPDID"],"DATA");
        if ($count > 5) {
            break;
        }
        $pdf->SetWidths(array(24, 24, 40, 40));
        $pdf->Row(
            array(mdsGetDate($row['Date']), $row['Type'], $row['Complaint'], $row['Remarks'] ? $row['Remarks'] : '-'),
            false, 8
        );
        $opdid = $row["OPDID"];
        if (count($notes) > 0) {
            $pdf->SetWidths(array(128));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array("Nursing Notes"), true);
            $pdf->SetWidths(array(60, 34, 34));
            $pdf->Row(array('Note', 'Created Date', 'Created User'), true, 8);
            foreach ($notes as $note) {
                $pdf->Row(array($note['notes'],mdsGetDate($note['CreateDate']),$note['CreateUser']));
            }
        }

        unset($result);
        $sql    = "
		SELECT
  prescribe_items.PRS_ITEM_ID,
  drugs.Name,
  prescribe_items.Dosage,
  prescribe_items.HowLong,
  prescribe_items.Frequency,
  prescribe_items.Quantity,
  prescribe_items.Status
FROM prescribe_items  JOIN opd_presciption on prescribe_items.PRES_ID=opd_presciption.PRSID, drugs
WHERE prescribe_items.Active = 1 AND prescribe_items.DRGID = drugs.DRGID AND opd_presciption.OPDID=$opdid";
        $result = $this->db->query($sql);

        if ($result->num_rows()) {
            $i = 0;
            while ($row = mysql_fetch_array($result->result_id)) {
                $prescription[$i] = array("Name"      => $row["Name"], "Dosage" => $row["Dosage"],
                                          "Frequency" => $row["Frequency"],
                                          "HowLong"   => $row["HowLong"]);
                $i++;
            }

        }


        if (isset($prescription)) {
            $pdf->SetWidths(array(128));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array("Prescription:"), true);
//            $pdf->SetWidths(array(53,15,30, 30));
            $pdf->SetWidths(array(128));
//            $pdf->SetAligns(array('L','L','L','L'));
            $pdf->SetAligns(array('L'));
            foreach ($prescription as $row2) {
                $pdf->Row(
                    array($row2['Name'] . " " . $row2['Dosage'] . " " . $row2['Frequency'] . "  " . $row2['HowLong'])
                );
            }

        }
    }
}

if (isset($admission_JSON)) {
    $count = 0;
    $pdf->Ln();
    $pdf->SetWidths(array(128));
    $pdf->SetAligns(array('C'));
    $pdf->Row(array($form_admission . "(Shows only last 5 admissions)"), true);
    $pdf->SetWidths(array(20, 25, 33, 25, 25));
    $pdf->Row(array('Date', 'Complaint', 'Discharge Diagnosis', 'Remarks', 'Discharge Date'), true, 8);
//    $pdf->SetFont('', '', 8);
    foreach ($admission_JSON as $row) {
        $count++;
        if ($count > 5) {
            break;
        }
        $pdf->Row(array(mdsGetDate($row['Date']), $row['Complaint'], $row['Diagnosis'] ? $row['Diagnosis'] : '-',
                        $row['Remarks'] ? $row['Remarks'] : '-',
                        mdsGetDate($row['DischargeDate']) ? mdsGetDate($row['DischargeDate']) : '-'), false, 8);
        $notes = Modules::run('admission/get_nursing_notes', $row["ADMID"], 'admission/view/' . $row["ADMID"], "DATA");

        if (count($notes) > 0) {
            $pdf->SetWidths(array(128));
            $pdf->SetAligns(array('L'));
            $pdf->Row(array("Nursing Notes"), true);
            $pdf->SetWidths(array(60, 34, 34));
            $pdf->Row(array('Note', 'Created Date', 'Created User'), true, 8);
            foreach ($notes as $note) {
                $pdf->Row(array($note['Note'],mdsGetDate($note['CreateDate']),$note['CreateUser']));
            }
        }

    }
}

$pat_pid_d = substr($pat_pid_d, 0, 3) . '_' . substr($pat_pid_d, 3, 3) . '_' . substr($pat_pid_d, 6, 3) . '_' . substr(
        $pat_pid_d, 9, 99
    );

$pdf->Output($pat_pid_d . ' patient_summery', 'I');
?>
