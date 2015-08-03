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

$this->load->library(
    'class/MDSReporter',
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A4', 'footer' => true)
);
$pdf = $this->mdsreporter;

$pdf->addPage();

$from = $from_date;
$to = $to_date;
$from_date = new DateTime($from_date);
$to_date = new DateTime($to_date);


$visitTypes = array();
$where = '';
$pdf->writeTitle($hospital);
$pdf->writeSubTitle(
    'Visit Complaints Treated From ' . $from_date->format('Y-m-d') . ' To ' . $to_date->format('Y-m-d')
);
$pdf->Ln();

//date+1
date_add($to_date, new DateInterval('P1D'));
//get all visit types
if ($visitType == 'All') {
    $query
        = "select distinct `VTYPID` from visit_type as vt,opd_visits as ov where ov.VisitType=vt.`VTYPID` and ov.DateTimeOfVisit between '{$from_date->format(
        'Y-m-d'
    )}' and '{$to_date->format('Y-m-d')}'";
    unset($result);
    $result = $this->db->query($query);
    foreach ($result->result_array() as $row) {
        array_push($visitTypes, $row['VTYPID']);
    }
} else {
    array_push($visitTypes, $visitType);
}
$orderBy = '';
switch ($sort) {
    case 'alpha':
        $orderBy = "order by `Name`";
        break;
    case 'freq':
        $orderBy = "order by cc desc,`Name`";
        break;

    default:
        $orderBy = "order by `Name`";
        break;
}

foreach ($visitTypes as $visitType) {

    $this->load->model('mvisit_type');
    $visitName = $this->mvisit_type->load($visitType)->Name;
    $query
        = "select `Name`,count(`Name`) as cc from complaints as c,opd_visits as ov where ov.VisitType='{$visitType}' and ov.DateTimeOfVisit between '{$from_date->format(
        'Y-m-d'
    )}' and '{$to_date->format(
        'Y-m-d'
    )}' and (ov.Complaint like c.`Name` or ov.Complaint like concat(c.`Name`,',%') or ov.Complaint like concat('%,',c.`Name`,',%') or ov.Complaint like concat('%,',c.`Name`)) group by `Name` {$orderBy}";
    unset($result);
    $result = $this->db->query($query);
    $count = $result->num_rows();
    if ($count > 0) {
        $pdf->SetWidths(array(128));
        $pdf->SetAligns(array('C'));
        $pdf->Row(array($visitName), true);
        $pdf->SetWidths(array(98, 30));
        $pdf->SetAligns(array('L', 'L'));
        $pdf->Row(array("Complaint Treated", "Number"), true);
        foreach ($result->result_array() as $row) {
            $pdf->Row(array($row['Name'], $row['cc']));
        }
    }
}

$pdf->Output("visit_complaints_treated from $from to $to", 'I');
?>