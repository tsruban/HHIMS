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
?>

<div class="panel panel-default"  >
	<div class="panel-heading"><b>Patient overview </b>
	</div>
	<?php
	$patInfo ="";
	if (!isset($image)) $image=base_url()."/images/patient.jpg";
	$tools = "<img src='".$image."' width=100 height=100 style='padding:2px;cursor:pointer' onclick=document.location='".site_url("attach/portrait/".$patient_info["PID"])."'>";
	echo  "<div id ='patientBanner' class='well'  style='padding:0px;'>\n";
	echo  "<table width=100% border=0 class=''>\n";
	echo  "<tr><td  rowspan=6 valign=top align=left width=10>".$tools."</td><td>Full Name:</td><td><b>";
	echo  $patient_info["Personal_Title"];
	echo  $patient_info["Personal_Used_Name"]."&nbsp;";
	echo  $patient_info["Full_Name_Registered"];
	echo "</b></td><td>HIN:</td><td><b>".$patient_info["HIN"]."</b>";
	echo  "<td  rowspan=6 valign=top align=left width=10>";
	echo  "<input type='button' class='btn btn-xs btn-warning pull-right' onclick=self.document.location='".site_url('form/edit/patient/'.$patient_info["PID"].'/?CONTINUE=patient/view/'.$patient_info["PID"].'')."' value='Edit'>";
	echo  "<tr><td>Gender:</td><td>".$patient_info["Gender"]."</td>";
	echo  "<td>NIC:</td><td>".$patient_info["NIC"]."</td></tr>\n";
	echo  "<tr><td>Date of birth:</td><td>".$patient_info["DateOfBirth"]."</td><td >Address:</td><td rowspan=3 valign=top>";
	echo  $patient_info["Address_Street"]."&nbsp;";
	echo  $patient_info["Address_Street1"]."<br>";
	echo  $patient_info["Address_Village"]."<br>";
	//echo  $patient_info["Address_DSDivision"]."<br>";
	echo  $patient_info["Address_District"]."<br>";
	echo  "</td></tr>\n";
	echo  "<tr><td>Age:</td><td>~";
	if ($patient_info["Age"]["years"]>0){
		echo  $patient_info["Age"]["years"]."Yrs&nbsp;";
	}
	echo  $patient_info["Age"]["months"]."Mths&nbsp;";
	echo  $patient_info["Age"]["days"]."Dys&nbsp;";
	echo  "</td><td></td></tr>\n";
	echo  "<tr><td>Civil Status:</td><td>".$patient_info["Personal_Civil_Status"]."</td><td></td></tr>\n";
	if ($patient_info["occupation"]!=""){
		echo  "<tr><td>Occupation:</td><td>".$patient_info["occupation"]."</td><td></td></tr>\n";
	}
	echo  "</table>\n";
	?>
</div>