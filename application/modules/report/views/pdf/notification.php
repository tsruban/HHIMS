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

// Document variables (to be passed to the script) - defined here for testing
$pat_hos_d = $hospital->Name; //Institute
$pat_dis_d = $notification->getValue("Disease"); //Disease to be notified
$pat_nam_d = $patient->Personal_Title . ' ' . $patient->Full_Name_Registered; //Patient name
$pat_pid_d = $patient->PID; //Patient record number
//if (!$pat_don_d) {
//    $pat_don_d = "-";
//}

$pat_con_d = ''; //Name of guardian/parent (for children)
//if ($notification->episode_type == 'Admissin') {
//    $pat_dvi_d = $admission->getValue("AdmissionDate"); //Date of visit (or admission - later)
//    $pat_bht_d = $admission->getValue("BHT") . 'BHT'; //Bed head ticket number (later)
//    $pat_bht_d = 'BHT'; //Bed head ticket number (later)
//    $pat_war_d = $ward->getValue("Name"); //Ward (later)
//}

$pat_age_d = $patient->getAge();
$pat_sex_d = $patient->getValue("Gender");
$pat_add_d = $patient->getAddress();
$pat_tel_d = $patient->getValue("Telephone"); //Home telephone number
$dat_d = date('Y-m-d'); //Date form produced
$pat_moh_d = '';

$this->load->helper('hdate');
if ($notification->getValue("Episode_Type") == 'admission') {
    $pat_don_d = $admission->getValue("OnSetDate");
    $pat_dvi_d = mdsGetDate($admission->getValue("AdmissionDate"));
    $pat_bht_d = $admission->getValue("BHT"); //Bed head ticket number (later)
    $pat_war_d = $ward->getValue("Name");
} else {
    if ($notification->getValue("Episode_Type") == 'opd') {

        $pat_don_d = $opd->getValue("OnSetDate");
        $pat_dvi_d = mdsGetDate($opd->getValue("DateTimeOfVisit"));
        $pat_war_d = $opd->getValue("VisitType");
        $pat_bht_d = "-";
    } else {
        return;
    }
}

//header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A4', 'footer' => true)
);
$pdf = $this->mdsreporter;
// Set base font to start
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(255, 0, 0);
// Add a new page to the document
$pdf->addPage();
$pdf->SetRightMargin(0);
$pdf->Image('images/06a_notification_form.jpg', 0, 0, 200);

// Constant for adjusting left margin and distance from top
$mar = 30;
$top = 15;
// Write data - field names
$pdf->SetXY($mar + 20, $top + 18);
$pdf->write(13, $pat_hos_d);
$pdf->SetXY($mar + 120, $top + 22);
$pdf->MultiCell(50, 5, $pat_dis_d);
$pdf->SetXY($mar + 10, $top + 29);
$pdf->write(13, $pat_nam_d);
$pdf->SetXY($mar + 125, $top + 29);
$pdf->write(13, $pat_don_d);
$pdf->SetXY($mar - 20, $top + 54);
$pdf->write(13, $pat_con_d);
$pdf->SetXY($mar + 125, $top + 44);
$pdf->write(13, $pat_dvi_d);
$pdf->SetXY($mar + 10, $top + 65);
$pdf->write(13, $pat_bht_d);
$pdf->SetXY($mar + 52, $top + 65);
$pdf->write(13, $pat_war_d);
$pdf->SetXY($mar + 97, $top + 65);
$pdf->write(13, $pat_age_d);
$pdf->SetXY($mar + 148, $top + 65);
$pdf->write(13, $pat_sex_d);
$pdf->SetXY($mar + 52, $top + 79);
$pdf->write(13, $pat_lab_d);
$pdf->SetXY($mar - 20, $top + 104);
$pdf->write(13, $pat_add_d);
$pdf->SetXY($mar + 35, $top + 127);
$pdf->write(13, $pat_tel_d);
$pdf->SetXY($mar + 140, $top + 141);
$pdf->write(13, $dat_d);
$pdf->SetXY($mar - 20, $top + 199);
$pdf->write(13, $pat_moh_d);

// Close the document and offer to show or save to ~/Downloads
$pdf->Output('notification_form.pdf', 'I');
?>
