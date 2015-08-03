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
    array('orientation' => 'L', 'unit' => 'mm', 'format' => 'A4', 'footer' => true)
);
$pdf = $this->mdsreporter;
$pdf->addPage();

$pdf->writeTitle($hospital);
$pdf->writeSubTitle('Midnight Census ' . $date);

if(count($wards)>0){

    foreach($wards as $ward){
        $pdf->Ln();
        $pdf->writeSSubTitle('Name '.$ward->Name.' : Type '.$ward->Type.' : Bed Count '.$ward->BedCount);

        $pdf->SetWidths(array(40, 25, 25, 25,25,25,25,25,25,25,25));
        $pdf->Row(array('Previous midnight balance','Admissions','Transfers in','Total','Discharges','Deaths < 48 hrs','Deaths > 48 hrs','Transfer out','Total2','Remaining'), TRUE,8, 5);

        $admissions=$ward->getAdmissionsByDate($date)->num_rows;
        $previousBalance=$ward->getPreviousMidnightBalance($date)->num_rows;
        $transfersIn=$ward->getTransfersIn($date)->num_rows;
        $total=$admissions+$previousBalance;
        $discharges=$ward->getDischarges($date)->num_rows;
        $deathsGt=$ward->getDeathsGt($date)->num_rows;
        $deathsLt=$ward->getDeathsLt($date)->num_rows;
        $transfersOut=$ward->getTransfersOut($date)->num_rows;
        $total2=$discharges+$deathsGt+$deathsLt+$transfersOut;
        $remain=$total-$total2;

        $pdf->Row(array($previousBalance,$admissions,$transfersIn,$total,$discharges,$deathsGt,$deathsLt,$transfersOut,$total2,$remain));

    }
}

$pdf->Output('midnight_census' . $date, 'I');
?>
