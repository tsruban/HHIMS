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
echo '<a href="'.site_url("patient/view/".$patient_info["PID"]).'"><div class="alert alert-info" style="margin-bottom:1px;padding-top:8px;padding-bottom:8px">';
	echo '<b style="font-size:16px;">';
		echo  $patient_info["Personal_Title"];
		echo  $patient_info["Personal_Used_Name"]."&nbsp;";
		echo  $patient_info["Full_Name_Registered"];
	echo '</b>';
	echo '&nbsp;/&nbsp;';
	echo  $patient_info["Gender"];
	echo '&nbsp;/&nbsp;';
		if ($patient_info["Age"]["years"]>0){
			echo  $patient_info["Age"]["years"]."Yrs&nbsp;";
		}
		echo  $patient_info["Age"]["months"]."Mths&nbsp;";
		echo  $patient_info["Age"]["days"]."Dys&nbsp;";
	echo '&nbsp;/&nbsp;';
	echo  $patient_info["Personal_Civil_Status"];
	echo '&nbsp;/&nbsp;';
	echo  $patient_info["Address_Village"];
	echo  '<span class="pull-right">'.$patient_info["HIN"].'</span>';
echo '</div></a>';
?>

