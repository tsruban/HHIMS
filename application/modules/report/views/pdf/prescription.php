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
    array('orientation' => 'P', 'unit' => 'mm', 'format' => array(72,$pageHeight), 'footer' => false)
);
$pdf = $this->mdsreporter;


$name = $patient->Personal_Title . ' ' . $patient->Full_Name_Registered; //returns the fullname
$reg_no = Modules::run('patient/print_hin',$patient->HIN);
$gender=$patient->Gender;
$pdf->addPage();
$pdf->SetAutoPageBreak(false);


$pdf->SetMargins(1, 1);
$pdf->SetXY(0, 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(0, 2, $hospital, 0, 'R');
$pdf->SetFont('Arial', 'BI', 5);
$pdf->MultiCell(0, 4, "Prescription - " . $date, 0, 'R');
$pdf->Image('images/rx.png', 0, -1, 8, 8);
$pdf->SetFont('Arial', '', 8);
//$pdf->SetXY(8, 6);
$pdf->MultiCell(0, 4, $name.'('.$gender.')'  , 0, 'L');
//$pdf->SetX(8);
$pdf->MultiCell(0, 4,  'HIN: '.$reg_no . ' Age: ' . $patient->getAge() , 0, 'L');

$pdf->Line(5, 15, 68, 15);

$pdf->setY(16);
foreach ($items as $item) {
    $txt = $item->drug_name . ' '.$item->drug_dose.' '. $item->drug_formulation . ' ' . $item->Dosage . ' ' . $item->Frequency . ' '
        . $item->HowLong;
    $pdf->MultiCell(0, 4, $txt, 0, 'L');
}

$pdf->Ln();
$pdf->MultiCell(0, 4, '.......................................................', 0, 'R');
$pdf->MultiCell(0, 4, 'Prescribed by: '.$prescription->PrescribeBy, 0, 'R');

$pdf->Output('prescription' . $date, 'I');
