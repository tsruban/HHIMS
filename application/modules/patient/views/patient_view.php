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
<?php echo Modules::run('menu'); //runs the available menu option to that usergroup ?>
<div class="container" style="width: 95%;">
	<div class="row" style="margin-top: 55px;">
		<div class="col-md-2 "><?php echo Modules::run('leftmenu/patient',$id,$patient_questionnaire_list); //runs the available left menu for preferance ?>
		</div>
		<div class="col-md-10 "><?php echo Modules::run('patient/banner_full',$id); ?>
		</div>
		<div class="well" style="padding: 2px;">
		
			<table border=0 width=100%>
				<tr>
					<td width=50% valign=top>
						<?php 
						if ($this->config->item('purpose') !="PC"){ ?>
							<div id="opd_cont" style='padding: 5px;'><?php echo $previous_visits; ?></div>
							<?php 
							if ($this->config->item('purpose') !="PP"){ ?>
								<div id="adm_cont" style='padding: 5px;'><?php echo $admissions; 							
							}
						}?></div>
						<?php 
						if ($this->config->item('purpose') !="PP"){ ?>
							<div id="clinc_cont" style='padding: 5px;'><?php echo $clinics; 
						}?>	</div>
						<div id="exam_cont" style='padding: 5px;'><?php echo $exams; ?></div>	
					</td>
					<td width=50% valign=top>
						<div id="his_cont" style='padding: 5px;'><?php echo $history; ?></div>
						<div id="alergy_cont" style='padding: 5px;'><?php echo $allergy; ?></div>
						<div id="pre_cont" style='padding: 5px;'><?php echo $prescriptions;  ?></div>
						<?php 
						if ($this->config->item('purpose') !="PP"){ ?>
							<div id="lab_cont" style='padding: 5px;'><?php echo $lab_orders; 
						}?></div>
						<div id="notes_cont" style='padding: 5px;'><?php print_r($notes);  ?></div>
						<div id="attach_cont" style='padding: 5px;'><?php echo $attachments; ?></div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
</div>
