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
$pdf->SetLeftMargin(5);
$pdf->SetRightMargin(5);
$pdf->writeTitle($hospital);
$pdf->writeSubTitle('Visit Details From ' . $from_date->format("Y-m-d") . ' to ' . $to_date->format("Y-m-d"));
$pdf->Ln(2);
//$pdf->SetWidths(array(15,30,10,30));
//$pdf->SetAligns(array('L','L','L','L'));
//$pdf->colRow(array('From:', $from_date->format('Y-m-d'),'To:',$to_date->format('Y-m-d')));

$i = 1;
for ($index = 0; $index <= $diff; $index++) {

    $date = $from_date->format("Y-m-d");
    $firstDay = findFirstAndLastDay($date);
    $firstDay = $firstDay[0];
//    echo $firstDay.'<br>';
    if ($firstDay == $date) {
        $i = 1;
    }

    $this->load->model('mopd','opd');

    $sql = "select p.Full_Name_Registered,EXTRACT(YEAR FROM (FROM_DAYS(DATEDIFF
    (NOW(),p.DateOfBirth)))) as years,EXTRACT(MONTH FROM DATEDIFF(NOW(),p.DateOfBirth))
    as months,EXTRACT(DAY FROM (FROM_DAYS(DATEDIFF(NOW(),p.DateOfBirth)))) as days
    ,p.Gender,p.Address_Village as village,ov.Complaint,vt.name as VisitType,ov.DateTimeOfVisit,p.LPID
    from opd_visits as ov join patient as p on ov.PID=p.PID JOIN visit_type as vt
  ON ov.VisitType=vt.VTYPID where ov.DateTimeOfVisit
    like '$date%' order by ov.DateTimeOfVisit asc";

    $result = $this->db->query($sql);


    $count = $result->num_rows();
    if ($count) {

        $pdf->writeSSubTitle($date, 8, false, 8);
        $pdf->SetWidths(array(10, 55, 15, 10, 40, 55, 15));
        $pdf->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'L'));
        $pdf->Row(array('No', 'Name', 'Age', 'Sex', 'Village', 'Complaint', 'Visit Type'), true, 6);
        foreach ($result->result_array() as $row) {
            $row['years'] = $row['years'] ? $row['years'] . 'y' : '';
            $row['months'] = $row['months'] ? $row['months'] . 'm' : '';
            $row['days'] = $row['days'] ? $row['days'] . 'd' : '';
            $row['Gender'] = $row['Gender'] == 'Male' ? 'M' : 'F';
            $pdf->Row(
                array($i, $row['Full_Name_Registered'] . '(' . $row['LPID'] . ')', "$row[years]$row[months]$row[days]"
                      , $row['Gender'], $row['village'],
                      $row['Complaint'], $row['VisitType']), false, 6, 4, 4
            );
            $i++;
        }
    }


    date_add($from_date, new DateInterval('P1D'));
}

$pdf->Output('visit_statistics_from ' . $from_date->format("Y-m-d") . ' to ' . $to_date->format("Y-m-d"), 'i');

function findFirstAndLastDay($anyDate)
{
    //$anyDate            =    '2009-08-25';    // date format should be yyyy-mm-dd
    list($yr, $mn, $dt) = @split('-', $anyDate); // separate year, month and date
    $timeStamp = mktime(0, 0, 0, $mn, 1, $yr); //Create time stamp of the first day from the give date.
//    $firstDay = date('D', $timeStamp);    //get first day of the given month
    $firstDay = date('Y-m-d', $timeStamp); //get first day of the given month
    list($y, $m, $t) = @split('-', date('Y-m-t', $timeStamp)); //Find the last date of the month and separating it
    $lastDayTimeStamp = mktime(0, 0, 0, $m, $t, $y); //create time stamp of the last date of the give month
//    $lastDay = date('D', $lastDayTimeStamp); // Find last day of the month
    $lastDay = date('Y-m-d', $lastDayTimeStamp); // Find last day of the month
    $arrDay = array("$firstDay", "$lastDay"); // return the result in an array format.
//    $arrDay = array("$timeStamp", "$lastDayTimeStamp"); // return the result in an array format.

    return $arrDay;
}

?>