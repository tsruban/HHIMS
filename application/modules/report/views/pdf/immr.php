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

//include_once 'mds_reporter/MDSReporter.php';
include_once 'application/libraries/class/MDSIMMR.php';
header("Content-type: application/pdf");
$pdf = new MDSIMMR('L','mm','A4');
define('FPDF_FONTPATH', 'application/libraries/class/fpdf/font/');
$pdf->AddFont('Times', '', 'times.php');
$pdf->AddFont('Times', 'B', 'timesbd.php');
$pdf->AddFont('Times', 'BI', 'timesbi.php');
$pdf->AddFont('Times', 'I', 'timesi.php');

$pdf->setHospitalId($hospitalId);
$pdf->loadData($year,$quarter);
$pdf->plotData();
//$pdf->Output();
$pdf->Output("immr_report.pdf","I");
?>
