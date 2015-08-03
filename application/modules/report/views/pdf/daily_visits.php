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
    array('orientation' => 'L', 'unit' => 'mm', 'format' => 'A5', 'footer' => true)
);
$pdf = $this->mdsreporter;
$pdf->addPage();

$pdf->writeTitle($hospital);
$pdf->writeSubTitle('OPD Attendances ' . $date);


$query = "select p.PID as pid,p.Full_Name_Registered as patient,Personal_Used_Name as patient2,u.FirstName as doctor,u.OtherName as doctor2,p.Gender as gender,ov.Complaint as complaint,ov.isNotify as notify from patient as p,`user` as u,opd_visits as ov where ov.DateTimeOfVisit LIKE '$date%' and ov.PID=p.PID and ov.Doctor=u.UID order by p.LPID";
unset($result);
$result = $this->db->query($query);
$count = $result->num_rows();

if ($count != 0) {
    $pdf->Ln();
    $pdf->SetWidths(array(20, 60, 50, 60));
    $pdf->Row(array('PID','Name','Complaint','Doctor'), TRUE);
    foreach ($result->result_array() as $row) {
        $notify=$row['notify']==0?'no':'yes';
        $pdf->Row(array($row['pid'], $row["patient2"].' '.$row["patient"], $row['complaint'],$row['doctor'].$row['doctor2']));
    }
    $pdf->MultiCell(0, 6, "Total : $count");
}
$pdf->Output('opd_visits' . $date, 'I');
?>
