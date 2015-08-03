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
if ($from_date == date('Y-m-d')) {
    $time = date('@H:i');
} else {
    $time = date('@24:00');
}

// Print two cards on the left side of the page (A5 landscape)
//$pdf->showData(10,0,$patient,$headings) ;
//$pdf->setDy(0);
$this->load->library('session');

$pdf->writeTitle($this->session->userdata("Hospital"));
$pdf->writeSubTitle('Daily Drug Dispensed ' . $from_date . $time);
$pdf->Ln();
$pdf->MultiCell(0, 4, 'List of drugs dispensed only', 0, 'C');

// OPD
$rsql = "SELECT who_drug.Name as 'name', SUM( prescribe_items.Quantity) as 'sum'  FROM `prescribe_items` ,`opd_presciption`,`who_drug` where
  (opd_presciption.PrescribeDate LIKE '$from_date%')
  AND (opd_presciption.PRSID =  prescribe_items.PRES_ID)
  AND(who_drug.wd_id=prescribe_items.DRGID)
  AND(prescribe_items.Status = 'Dispensed')
  AND(prescribe_items.Active = 1)
GROUP BY prescribe_items.DRGID ORDER BY who_drug.Name";
unset($result);
$result = $this->db->query($rsql);
$count = $result->num_rows();
$pdf->SetWidths(array($pdf->getAsPercentage(10), $pdf->getAsPercentage(70), $pdf->getAsPercentage(20)));
$pdf->Ln();
if ($count) {
    $x = 0;
//    $pdf->writeSSubTitle('OPD: ', 10, true, 0);
    $pdf->MultiCell(0, 6, 'OPD: ');

    $pdf->Row(array('', 'Drug Name', 'Quantity Dispensed'), true);
    foreach ($result->result_array() as $row) {
        $x += 1;
        $pdf->Row(array($x, $row['name'], $row['sum']));
    }
} else {

}

// Clinic
$rsql = "SELECT who_drug.Name as 'name', SUM( clinic_prescribe_items.Quantity) as 'sum'  FROM `clinic_prescribe_items` ,`clinic_prescription`,`who_drug` where
  (clinic_prescription.PrescribeDate LIKE '$from_date%')
  AND (clinic_prescription.clinic_prescription_id =  clinic_prescribe_items.clinic_prescription_id)
  AND(who_drug.wd_id=clinic_prescribe_items.DRGID)
  AND(clinic_prescribe_items.Status = 'Dispensed')
  AND(clinic_prescribe_items.Active = 1)
GROUP BY clinic_prescribe_items.DRGID ORDER BY who_drug.Name;";
unset($result);
$result = $this->db->query($rsql);

$count = $result->num_rows();
$pdf->SetWidths(array($pdf->getAsPercentage(10), $pdf->getAsPercentage(70), $pdf->getAsPercentage(20)));
$pdf->Ln();
if ($count) {
    $x = 0;
    $pdf->SetFont("arial", 'B', 12);
    $pdf->MultiCell(0, 6, 'Clinics: ');
    $pdf->Row(array('', 'Drug Name', 'Quantity Dispensed'), true);
    foreach ($result->result_array() as $row) {
        $x += 1;
        $pdf->Row(array($x, $row['name'], $row['sum']));
    }
} else {

}

// Admission
$rsql = "SELECT drugs.Name as 'name', SUM( prescribe_items.Quantity) as 'sum'  FROM `prescribe_items` ,`opd_presciption`,`drugs` where 
                            (opd_presciption.PrescribeDate LIKE '$from_date%') 
                            AND (opd_presciption.PRSID =  prescribe_items.PRES_ID)
                            AND (opd_presciption.GetFrom =  '')
                            AND(drugs.DRGID=prescribe_items.DRGID)
                            AND(prescribe_items.Status = 'Dispensed') 
                            AND(prescribe_items.Active = 1) 
                            GROUP BY prescribe_items.DRGID ORDER BY drugs.Name";
unset($result);
$result = $this->db->query($rsql);

$count = $result->num_rows();
$pdf->SetWidths(array($pdf->getAsPercentage(10), $pdf->getAsPercentage(70), $pdf->getAsPercentage(20)));
$pdf->Ln();
if ($count) {
    $x = 0;
    $pdf->SetFont("arial", 'B', 12);
    $pdf->MultiCell(0, 6, 'Admission: ');

    $pdf->Row(array('', 'Drug Name', 'Quantity Dispensed'), true);
    foreach ($result->result_array() as $row) {
        $x += 1;
        $pdf->Row(array($x, $row['name'], $row['sum']));
    }
} else {

}


// Close the document and offer to show or save to ~/Downloads
$pdf->Output('daily_drug_dispense-' . $from_date . $time, 'i');
?>
