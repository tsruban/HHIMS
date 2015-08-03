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
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A5', 'footer' => false)
);
$pdf = $this->mdsreporter;


#.......................................................................................................................................
// Create fpdf object
$pdf->addPage();
//$pdf->SetMargins(0,0,0);
$pdf->Write(5, '===========================================================================');
$pdf->Ln(3);
$pdf->Write(4, date('Y-m-d H:i:s') . '   Patient: ' .$patient_info['Personal_Title'].$patient_info["Full_Name_Registered"].' HIN:  '.Modules::run('patient/print_hin',$patient_info['HIN']).' ');
$pdf->Write(4, '   Doctor: ' . $opd_visits_info["Doctor"]);
$pdf->Ln(3);
$pdf->Write(5, '===========================================================================');
$pdf->Ln(4);
$pdf->Write(5, 'Visit Information');
$pdf->Ln(3);
$pdf->Write(5, '------------------------------------');
$pdf->Ln(3);
$pdf->Write(4, 'Date & Time of visit:' . $opd_visits_info["DateTimeOfVisit"]);
$pdf->Write(4, ', Complaint:' . $opd_visits_info["Complaint"]);
if (!empty($opd_visits_info["Remarks"])) {
    $pdf->Write(4, ', Remarks:' . $opd_visits_info["Remarks"]);
}

// PRINT ALLERGIES
if ((isset($patient_allergy_list))&&(!empty($patient_allergy_list))){
    $pdf->Ln(4);
    $pdf->Write(5, 'Allergies');
    $pdf->Ln(3);
    $pdf->Write(5, '------------------------------------');
    for ($i=0;$i<count($patient_allergy_list); ++$i){
        $pdf->Ln(3);
        $pdf->Write(4,$patient_allergy_list[$i]["CreateDate"].', '.$patient_allergy_list[$i]["Name"].', '.$patient_allergy_list[$i]["Status"].', '.$patient_allergy_list[$i]["Remarks"]);
    }
}

// PRINT PAST HISTORY
if ((isset($patient_history_list))&&(!empty($patient_history_list))){
    $pdf->Ln(4);
    $pdf->Write(5, 'Past History');
    $pdf->Ln(3);
    $pdf->Write(5, '------------------------------------');
    for ($i=0;$i<count($patient_history_list); ++$i){
        $pdf->Ln(3);
        $pdf->Write(4,$patient_history_list[$i]["HistoryDate"].', '.$patient_history_list[$i]["SNOMED_Text"]);
    }
}

// PRINT EXAMINATIONS
if ((isset($patient_exams_list))&&(!empty($patient_exams_list))){
    $pdf->Ln(4);
    $pdf->Write(5, 'Examination');
    $pdf->Ln(3);
    $pdf->Write(5, '------------------------------------');
    for ($i=0;$i<count($patient_exams_list); ++$i){
        $pdf->Ln(3);
        $pdf->Write(4,$patient_exams_list[$i]["CreateDate"]);
        if (isset($patient_exams_list[$i]["Weight"])&&($patient_exams_list[$i]["Weight"]>0)){
            $pdf->Write(4,', '.$patient_exams_list[$i]["Weight"].'Kg');
        }
        if (isset($patient_exams_list[$i]["Height"])&&($patient_exams_list[$i]["Height"]>0)&&($patient_exams_list[$i]["Height"]<3)){
            $pdf->Write(4,', '. $patient_exams_list[$i]["Height"].'m');
        }
        $pdf->Write(4,', '.$patient_exams_list[$i]["sys_BP"].'/'.$patient_exams_list[$i]["diast_BP"]);

    }
}

// PRINT LAB ORDERS
if ((isset($patient_lab_order_list))&&(!empty($patient_lab_order_list))){
    $pdf->Ln(4);
    $pdf->Write(5, 'Lab Orders');
    $pdf->Ln(3);
    $pdf->Write(5, '------------------------------------');
    for ($i=0;$i<count($patient_lab_order_list); ++$i){
        $pdf->Ln(3);
        $pdf->Write(4,$patient_lab_order_list[$i]["TestGroupName"].'('.$patient_lab_order_list[$i]["OrderDate"].')'.', '.$patient_lab_order_list[$i]["Status"]);
    }

}

// PRINT TREATMENTS
if ((isset($patient_treatment_list))&&(!empty($patient_treatment_list))){
    $pdf->Ln(4);
    $pdf->Write(5, 'Treatments');
    $pdf->Ln(3);
    $pdf->Write(5, '------------------------------------');
    for ($i=0;$i<count($patient_treatment_list); ++$i){
        $pdf->Ln(3);
        $pdf->Write(4,$patient_treatment_list[$i]["CreateDate"]);
        $pdf->Write(4,', '.$patient_treatment_list[$i]["Treatment"]);
        $pdf->Write(4,', '.$patient_treatment_list[$i]["Remarks"]);
        $pdf->Write(4,', '.$patient_treatment_list[$i]["Status"]);
    }
}


// PRINT PRESCRIPTIONS
if ((isset($prescribe_items_list))&&(!empty($prescribe_items_list))){
    $pdf->Ln(4);
    $pdf->Write(5, 'Prescriptions');
    $pdf->Ln(3);
    $pdf->Write(5, '------------------------------------');
    foreach($prescribe_items_list as $items){
        foreach($items as $item){
            $pdf->Ln(3);
            if($item['drug_list']=='who_drug'){
                $drug_info = $this->mpersistent->open_id($item["DRGID"], "who_drug", "wd_id");
            }
            if(!isset($drug_info['name']))
                continue;
            $pdf->Write(5,$drug_info['name']);
            $pdf->Write(5,', '.$item['Frequency']);
            $pdf->Write(5,', '.$item['HowLong']);
        }

    }
}
$pdf->Ln(3);
$pdf->Write(5, '===========================================================================');
$pdf->Output(' clinic_book.pdf', 'I');
