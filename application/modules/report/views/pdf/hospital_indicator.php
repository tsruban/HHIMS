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




$from_date = new DateTime($from_date);
$to_date = new DateTime($to_date);

if ($to_date->format("Y-m-d") <= $from_date->format("Y-m-d")){
    $to_date = new DateTime(date("Y-m-d"));
}



$from=$from_date->format("Y-m-d");
$to=$to_date->format("Y-m-d");
echo "<html>";
echo "<head>";
echo "<style type='text/css'>
	.t_head {font-weight: bold; font-size:16px;font-family:Georgia;border:2px solid #000000;}
	.r_head {font-weight: bold; font-size:12px;border-top:1px solid #000000;text-align:center;border-right:1px solid #000000;border-bottom:1px solid #000000;}
	.r_data {font-size:12px;border-top:1px solid #000000;border-right:1px solid #000000;}
	.r_right {text-align:right;}
	.r_left_border {border-left:1px solid #000000;}
	.r_total { text-align:right; font-size:14px;border-right:1px solid #000000;font-weight: bold;border-top:2px solid #000000;border-bottom:2px solid #000000;}
</style>";

echo "</head>";
echo "<body style='background:#f1f1f1;'>";
echo "<table border=0 cellspacing=0 cellpadding=5 align=center style='font-family:Arial;font-size:10px;background:#ffffff;'>";
echo "<tr>";
echo "<td colspan=10 align=center class='t_head'><b>".$hospital."<br>Hospital Performance Indicators  from ".$from_date->format("Y-m-d")." to ".$to_date->format("Y-m-d")."<br></b></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='r_head r_left_border' rowspan='2'>Ward</td><td class='r_head' rowspan='2'>No. of beds</td><td class='r_head' colspan=2>Admission</td><td class='r_head' rowspan=2>Total1</td><td rowspan='2'  class='r_head'>Discharged<br> Alive</td><td colspan=2  class='r_head'>Deaths</td><td  class='r_head' rowspan=2>Transfers Out</td><td  class='r_head' rowspan=2>Total2</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='r_head'>New </td><td class='r_head' >Transfers In</td><td  class='r_head'>&lt; 48Hrs</td><td  class='r_head'>48Hrs+</td>";
echo "</tr>";


$wqry = "SELECT WID,Name,BedCount From ward where Active = 1";
$wres = $this->db->query($wqry);
if (!$wres) {
		echo " <script language='javascript'> alert('ERROR in query');</script>\n";
		return "";
}	
$total = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$i=0;
while($wrow = mysql_fetch_array($wres->result_id))  {
	$sql_adm = " SELECT count(admission.ADMID) as tc  from admission  WHERE  (admission.AdmitTo ='".$wrow["WID"]."' ) AND ( substring(admission.AdmissionDate,1,10) > '".$from."') AND (substring(admission.AdmissionDate,1,10) <= '".$to."')";
	$result_adm = $this->db->query($sql_adm);
    $row_adm = mysql_fetch_array($result_adm->result_id);
	
	$sql_tr_in = " SELECT count(ADTR)  as tc from admission_transfer  WHERE  (TransferTo ='".$wrow["WID"]."' ) AND ( substring(TransferDate,1,10) > '".$from."') AND ( substring(TransferDate,1,10) <= '".$to."')";
	$res_tr_in = $this->db->query($sql_tr_in);
    $row_tr_in = mysql_fetch_array($res_tr_in->result_id);

	$sql_dis_alive = " SELECT count(admission.ADMID)  as tc  from admission  WHERE  (admission.Ward ='".$wrow["WID"]."' )AND (admission.OutCome !='Died' ) AND ( substring(admission.DischargeDate,1,10) > '".$from."') AND (substring(admission.DischargeDate,1,10) <= '".$to."')";
	$res_dis_alive = $this->db->query($sql_dis_alive);
    $row_dis_alive = mysql_fetch_array($res_dis_alive->result_id);
	
	$sql_dis_less_48 = " SELECT count(admission.ADMID)  as tc from admission  WHERE  (admission.Ward ='".$wrow["WID"]."' ) AND (admission.OutCome ='Died' ) and (DATEDIFF(substring(admission.DeathDate,1,10),substring(admission.AdmissionDate,1,10))<2 ) AND ( substring(admission.DischargeDate,1,10) > '".$from."') AND (substring(admission.DischargeDate,1,10) <= '".$to."')";
    $result_dis_less_48 = $this->db->query($sql_dis_less_48);
    $row_dis_less_48 = mysql_fetch_array($result_dis_less_48->result_id);
	
    $sql_dis_greater_48 = " SELECT count(admission.ADMID)  as tc from admission  WHERE  (admission.Ward ='".$wrow["WID"]."' ) AND (admission.OutCome ='Died' ) and (DATEDIFF(substring(admission.DeathDate,1,10),substring(admission.AdmissionDate,1,10))>=2 )AND ( substring(admission.DischargeDate,1,10) > '".$from."') AND (substring(admission.DischargeDate,1,10) <= '".$to."')";
    $result_dis_greater_48 = $this->db->query($sql_dis_greater_48);
    $row_dis_greater_48 = mysql_fetch_array($result_dis_greater_48->result_id);
	
	$sql_tr_out = " SELECT count(ADTR)  as tc from admission_transfer  WHERE  (TransferFrom ='".$wrow["WID"]."' ) AND ( substring(TransferDate,1,10) > '".$from."') AND ( substring(TransferDate,1,10) <= '".$to."')";
	$res_tr_out = $this->db->query($sql_tr_out);
    $row_tr_out = mysql_fetch_array($res_tr_out->result_id);
	
	echo "<tr>";
	echo "<td class='r_data r_left_border'>".$wrow["Name"]."</td>";
	echo "<td class='r_data r_right'>".$wrow["BedCount"]."</td>"; $total[1] += $wrow["BedCount"];
	echo "<td class='r_data r_right'>".$row_adm[0]."</td>"; $total[2] += $row_adm[0];
	echo "<td class='r_data r_right'>".$row_tr_in[0]."</td>";$total[3] +=$row_tr_in[0];
	echo "<td class='r_data r_right'><b>".($row_adm[0]+$row_tr_in[0])."</b></td>";$total[4]+= $row_adm[0]+$row_tr_in[0];
	echo "<td class='r_data r_right'>".$row_dis_alive[0]."</td>";$total[5]+=$row_dis_alive[0];
	echo "<td class='r_data r_right'>".$row_dis_less_48[0]."</td>";$total[6]+=$row_dis_less_48[0];
	echo "<td class='r_data r_right'>".$row_dis_greater_48[0]."</td>";$total[7]+=$row_dis_greater_48[0];
	echo "<td class='r_data r_right'>".$row_tr_out[0]."</td>";$total[8]+=$row_tr_out[0];
	echo "<td class='r_data r_right'><b>".($row_dis_alive[0]+$row_dis_less_48[0]+$row_dis_greater_48[0]+$row_tr_out[0])."</b></td>";$total[9]+=$row_dis_alive[0]+$row_dis_less_48[0]+$row_dis_greater_48[0]+$row_tr_out[0];
	echo "</tr>";
	$total[$i] ++;

}	
	echo "<tr >";
	echo "<td class='r_total r_left_border'>TOTAL</td>";
	echo "<td class='r_total'>".$total[1]."</td>";
	echo "<td class='r_total'>".$total[2]."</td>";
	echo "<td class='r_total'>".$total[3]."</td>";
	echo "<td class='r_total'>".$total[4]."</td>";
	echo "<td class='r_total'>".$total[5]."</td>";
	echo "<td class='r_total'>".$total[6]."</td>";
	echo "<td class='r_total'>".$total[7]."</td>";
	echo "<td class='r_total'>".$total[8]."</td>";
	echo "<td class='r_total'>".$total[9]."</td>";
	echo "</tr>";
echo "</table>";
echo "</body>";
echo "</html>";



function sanitize($data){
    $data=trim($data);
    $data=htmlspecialchars($data);
    $data = mysql_escape_string($data);
    $data = stripslashes($data);
    return $data;
}

?>
