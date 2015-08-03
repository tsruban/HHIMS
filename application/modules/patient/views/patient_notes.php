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

	include("header.php");	///loads the html HEAD section (JS,CSS)
?>

<div class="container" style="width:95%;">
	<table border=1 style="background:#FFFFFF" width=90% align="center">
		<tr>
			<td>
				<h3><?php echo 	$this->session->userdata('Hospital'); ?></h3><hr>
				<?php //print_r($patient_info); ?>
				<p>
				Patient:<?php echo 	$patient_info["Personal_Title"]. ' ' .$patient_info["Personal_Used_Name"] . ' ' .$patient_info["Full_Name_Registered"]; ?><br>
				HIN:<?php echo 	$patient_info["HIN"]; ?><br>
				Gender:<?php echo 	$patient_info["Gender"]; ?><br>
				Age:<?php echo 	$patient_info["Age"]["years"]; ?><br><hr>
				<h4>Patient related notes</h4><hr>
				<?php
				if (isset($patient_notes_list)){
					foreach($patient_notes_list as $key=>$value) {
						echo $value["CreateDate"].' : "'.$value["notes"].'"  '.$value["CreateUser"].'<br>';
					}
				}
				?>
				<hr><h4>OPD related notes</h4><hr>
				<?php
				if (isset($opd_notes_list)){
					foreach($opd_notes_list as $key=>$value) {
						echo $value["CreateDate"].' : "'.$value["notes"].'"  '.$value["CreateUser"].'<br>';
					}
				}
				?>
				</P>
			</td>
		</tr>
	</table>
</div>
