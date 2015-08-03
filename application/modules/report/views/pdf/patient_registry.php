<?php

//  ------------------------------------------------------------------------ //
//                   MDSFoss - Free Patient Record System                    //
//            Copyright (c) 2011 Net Com Technologies (Sri Lanka)            //
//                        <http://www.mdsfoss.org/>                          //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation.                                            //									     									 //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even an implied warranty of            //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to:                               //
//  Free Software  MDSFoss                                                   //
//  C/- Net Com Technologies,                                                //
//  15B Fullerton Estate II,                                                 //
//  Gamagoda, Kalutara, Sri Lanka                                            //
//  ------------------------------------------------------------------------ //
//  Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org       //
//  Consultant: Dr. Denham Pole          	DrPole[AT]gmail.com          //
//  URL: http://www.mdsfoss.org                                              //
// ------------------------------------------------------------------------- //
header("Content-type: application/pdf");
$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A4', 'footer' => true)
);
$pdf = $this->mdsreporter;

if (!$from_date && !$to_date) {
    echo 'please spacify valid date ';
    exit();
}
// TSR: commented
//$diff = $from_date->diff($to_date)->format('%a');
//TSR:Added
$startDate = strtotime($from_date);
$endDate = strtotime($to_date);
$diff = intval(abs(($startDate - $endDate) / 86400));
//TSR

$from_date = new DateTime($from_date);
$to_date = new DateTime($to_date);



$pdf->AddPage();
//setup page title
$pdf->writeTitle($hospital);
$pdf->writeSubTitle('Visit Statistics From ' . $from_date->format("Y-m-d") . ' to ' . $to_date->format("Y-m-d"));
$pdf->Ln(3);

$pdf->SetWidths(array(30, 30, 30, 30));
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Row(array('Date', 'OPD Visits', 'Admissions', 'Clinics'), true);



for ($index = 0; $index <= $diff; $index++) {

    $date = $from_date->format("Y-m-d");

    $sql_opd = "select count(PID) as 'count' from opd_visits as ov where ov.DateTimeOfVisit like '{$date}%' and ov.VisitType='OPD Visit' group by substring(ov.DateTimeOfVisit,1,10)";
    $result_opd = $this->db->query($sql_opd);
    $row_opd = $result_opd->first_row();

    $sql_adm = "select count(PID) as 'count' from admission as ad where ad.AdmissionDate like '$date%' group by substring(ad.AdmissionDate,1,10);";
    $result_adm = $this->db->query($sql_adm);
    $row_adm = $result_adm->first_row();

    $sql_cli = "select count(PID) as 'count' from opd_visits as ov where ov.DateTimeOfVisit like '{$date}%' and ov.VisitType!='OPD Visit' group by substring(ov.DateTimeOfVisit,1,10);";
    $result_cli = $this->db->query($sql_cli);
    $row_cli = $result_cli->first_row();

    $opd_count = $row_opd ? $row_opd->count : 0;
    $adm_count = $row_adm ? $row_adm->count : 0;
    $cli_count = $row_cli ? $row_cli->count : 0;

    $pdf->Row(array($date, $opd_count, $adm_count, $cli_count));
    date_add($from_date, new DateInterval('P1D'));
}

$pdf->Output('visit_statistics_from ' . $from_date->format("Y-m-d") . ' to ' . $to_date->format("Y-m-d"), 'i');
?>