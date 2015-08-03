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
    array('orientation' => 'P', 'unit' => 'mm', 'format' => 'A4', 'footer' => true)
);
$pdf = $this->mdsreporter;
// Add a new page to the document
$pdf->addPage();


$pdf->writeTitle($hospital);
$pdf->writeSubTitle('Drug Order List ('.$drug_stock->name.')');
$pdf->writeSSubTitle('Stock less than '.$min_stock, 10, true, 0);


$count = $query->num_rows();
if (!$count) {
    $pdf->MultiCell(0, 6, 'Nothing to display...');
    $pdf->Output('drug_order-', 'i');
    exit();
}
$pdf->SetWidths(array(10,60,30,30));
$pdf->Ln();
if ($count) {
    $x=0;
    $pdf->Row(array('','Drug Name', 'Current Stock', 'Order Required'), true);
    foreach ($query->result() as $row){
        $x+=1;
        $pdf->Row(array($x, $row->name, $row->who_drug_count,''));
    }
} else {
    //
}

//$pdf->Output('daily_drug_dispense-' . $from_date . $time, 'i');
$pdf->Output('drug_order', 'i');
?>
