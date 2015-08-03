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
    array('orientation' => 'P', 'unit' => 'mm', 'format' => array(80,44), 'footer' => false)
);
//new MDSReporter('P', 'mm', array(80,44),false);
$pdf = $this->mdsreporter;


$appointment=$this->load->model('mappointment','appointment');
$appointment->load($appId);
if ($appointment->getValue("PID") =="") {
	die("ERROR");
}
$patient = $this->load->model('mpatient','patient');
$patient->openId($appointment->getValue("PID"));
$date=$appointment->getValue("VDate");
$name = $patient->Personal_Title.' '.$patient->Full_Name_Registered; //returns the fullname
$reg_no=Modules::run('patient/print_hin',$patient->HIN);
$pdf->addPage();
$pdf->SetAutoPageBreak(false);

//sequence number generator

$seqNo=$appointment->getValue("Token");


// echo $seqNo;
$pdf->SetMargins(0,0);
$pdf->SetXY(0,1);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(0,2,$hospital,0,'C');
$pdf->SetFont('Arial','BI',5);
$pdf->MultiCell(0,4,$appointment->getValue("Type")." Appointment Slip",0,'C');
//$pdf->MultiCell(0,0,'','B','C');
$pdf->Line(5,6,75,6);
$pdf->SetY(6);
$pdf->SetFont('Arial','BI',10);
$pdf->MultiCell(0,4,$date,0,'C');
// $pdf->Ln();
$pdf->SetFont('Arial','B',25);
$pdf->setY(8);
if($seqNo%2!=0){
 $pdf->MultiCell(0,10,$seqNo.'  A',0,'C');
}else{
 $pdf->MultiCell(0,10,$seqNo.'  B',0,'C');
}
// $pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->setY(16);
$pdf->MultiCell(0,4,$name,0,'C');
$pdf->MultiCell(0,3.8,"Register No.: ".$reg_no,0,'C');
// $pdf->MultiCell(0,1,'');
$barcode=$reg_no;
//$barcode='123456';
$xpos=40-($pdf->getBarcodeWidth($barcode)/2);
$pdf->SetY(25);
$pdf->setBarcode($barcode,$xpos,$pdf->GetY(),false,0,false);
$pdf->Line(5,37,75,37);
$pdf->SetY(39);
$pdf->SetFont('Arial','',6);
$footerText=$token_text;
if(!$footerText){
    $footerText=date('d/m/Y@h:i A');
}
$pdf->MultiCell(0, 1 ,$footerText ,0,'C');
$pdf->Output('opd_slip' . $date, 'I');
?>
