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
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
echo "\n<html xmlns='http://www.w3.org/1999/xhtml'>";
echo "\n<head>";
echo "\n<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
echo "\n<meta http-equiv='refresh' content='60' > ";
echo "\n<title>".$this->config->item('title')."</title>";
echo "\n<link rel='icon' type='". base_url()."image/ico' href='images/mds-icon.png'>";
echo "\n<link rel='shortcut icon' href='". base_url()."images/mds-icon.png'>";
echo "\n<link href='". base_url()."/css/mdstheme_navy.css' rel='stylesheet' type='text/css'>";
echo "\n<script type='text/javascript' src='". base_url()."js/jquery.js'></script>";
echo "\n    <script type='text/javascript' src='".base_url()."js/bootstrap/js/bootstrap.min.js' ></script>";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap-theme.min.css' rel='stylesheet' type='text/css' />";  
echo "\n<script type='text/javascript' src='". base_url()."/js/mdsCore.js'></script> ";
echo "\n<script type='text/javascript' src='". base_url()."/js/jquery.hotkeys-0.7.9.min.js'></script>";
echo "\n</head>";
	
?>
<?php echo Modules::run('menu'); //runs the available menu option to that usergroup ?>
<div class="container" style="width:95%;">
	<div class="row" style="margin-top:55px;">
	  <div class="col-md-2 ">
		<?php echo Modules::run('leftmenu/opd',$OPDID,$PID,$opd_visits_info); //runs the available left menu for preferance ?>
	  </div>
	  <div class="col-md-10 " >
	  <div class="panel panel-default"  >
			<div class="panel-heading"><b>Patient visit overview </b>
			</div>
		<?php
		$patInfo ="";
		//$mdsPermission = MDSPermission::GetInstance();
		//if ($mdsPermission->haveAccess($_SESSION["UGID"],"patient_Edit"))
		$tools = "<img src='".base_url()."/images/patient.jpg' width=100 height=100 style='padding:2px;'>";
		echo  "<div id ='patientBanner' class='well'  style='padding:0px;'>\n";
		echo  "<table width=100% border=0 class='' style='font-size:0.95em;'>\n";
		echo  "<tr><td  rowspan=5 valign=top align=left width=10>".$tools."</td><td>Full Name:</td><td><b>";
		echo  $patient_info["Personal_Title"];
		echo  $patient_info["Personal_Used_Name"]."&nbsp;";
		echo  $patient_info["Full_Name_Registered"];
		echo "</b></td><td>HIN:</td><td><b>".$patient_info["HIN"]."</b>";
		echo  "<td  rowspan=5 valign=top align=left width=10>";
		echo  "<input type='button' class='btn btn-xs btn-warning pull-right' onclick=self.document.location='".site_url('form/edit/patient/'.$patient_info["PID"].'?CONTINUE=/opd/view/'.$opd_visits_info["OPDID"])."' value='Edit'>";
		echo  "<tr><td>Gender:</td><td><b>".$patient_info["Gender"]."</b></td>";
		echo  "<td>NIC:</td><td>".$patient_info["NIC"]."</td></tr>\n";
		echo  "<tr><td>Date of birth:</td><td><b>".$patient_info["DateOfBirth"]."</b></td><td >Address:</td><td rowspan=3 valign=top>";
		echo  $patient_info["Address_Street"]."&nbsp;";
		echo  $patient_info["Address_Street1"]."<br>";
		echo  $patient_info["Address_Village"]."<br>";
		//echo  $patient_info["Address_DSDivision"]."<br>";
		echo  $patient_info["Address_District"]."<br>";
		echo  "</td></tr>\n";
		echo  "<tr><td>Age:</td><td><b>~";
		if ($patient_info["Age"]["years"]>0){
			echo  $patient_info["Age"]["years"]."Yrs&nbsp;";
		}
		echo  $patient_info["Age"]["months"]."Mths&nbsp;";
		echo  $patient_info["Age"]["days"]."Dys&nbsp;";
		echo  "</b></td><td></td></tr>\n";
		echo  "<tr><td>Civil Status:</td><td>".$patient_info["Personal_Civil_Status"]."</td><td></td></tr>\n";
		echo  "</table></div>\n";
		?>
		</div>
			<?php 
			if (!empty($notification["complaint_data"])){
				if (empty($notification["notification_data"])){
					echo '<div class="alert alert-danger"><b>Notification alert: </b> Complaint:  <b>'.$notification["complaint_data"]["Name"].'</b><br>';
					echo 'Do you want to notify this?   ';
					echo '<a class="btn btn-sm btn-default" href="'.site_url("notification/create/opd/".$opd_visits_info["OPDID"]."?CONTINUE=opd/view/".$opd_visits_info["OPDID"]).'">Yes</a>';
					echo '</div>';
				}
				else{
					echo '<div class="alert alert-warning"><b>Notification for </b> Complaint,  <b>"'.$notification["complaint_data"]["Name"].'"</b> created. ';
					echo 'Do you want to    ';
					echo '<a  target="_blank" href="'.site_url("notification/view/".$notification["notification_data"]["NOTIFICATION_ID"]).'">send</a>?&nbsp;&nbsp;&nbsp;';
					echo 'Do you want to    ';
					echo '<a  target="_blank" href="'.site_url("notification/edit/".$notification["notification_data"]["NOTIFICATION_ID"]).'">edit </a>?';
					echo '</div>';
				}
			}
			//print_r($opd_visits_info); 
			//print_r($this->session)?>
			<div class="panel panel-default"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading warning" ><b>Visit information</b></div>
					<?php
						if ($opd_visits_info["referred_admission_id"] >0){
							echo '&nbsp;<span class="label label-info"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;This visit referred to admission </span>';
							echo '<a class="btn btn-default btn-xs" href="'.site_url("admission/view/".$opd_visits_info["referred_admission_id"]).'"> Open </a>';
						}
						if ($opd_visits_info["is_refered"]  == 1){
							echo '&nbsp;<span class="label label-warning"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;This visit referred to admission. You can proceed to admission by clicking on 
							<a href="'.site_url("opd/refers").'" target="_blank">"OPD Refer"</a> on top menu </span>';
							//echo '<a class="btn btn-default btn-xs" href="'.site_url("admission/view/".$opd_visits_info["referred_admission_id"]).'"> Open </a>';
						}
						echo '<table class="table table-condensed"  style="font-size:0.95em;margin-bottom:0px;">';
							echo '<tr>';
								echo '<td>';
									echo 'Type: '.$opd_visits_info["visit_type_name"];
								echo '</td>';
								echo '<td>';
									echo 'Date & Time of visit: '.$opd_visits_info["DateTimeOfVisit"];
								echo '</td>';
								echo '<td>';
									echo 'Onset Date: '.$opd_visits_info["OnSetDate"];
								echo '</td>';
								echo '<td>';
									echo 'Doctor: '.$opd_visits_info["Doctor"];
									if ($this->config->item('block_opd_after') >= $opd_visits_info["days"]){	
										echo  $opd_visits_info["days"]."<input type='button' class='btn btn-xs btn-warning pull-right' onclick=self.document.location='".site_url('form/edit/opd_visits/'.$opd_visits_info["OPDID"])."' value='Edit'>";
									}
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>';
									echo 'Complaint: <b>'.$opd_visits_info["Complaint"].'</b>';
								echo '</td>';
								echo '<td>';
									echo 'Notify: ';
									echo ($opd_visits_info["isNotify"]==1)?"YES":"NO";
								echo '</td>';
								echo '<td colspan=2>';
									echo 'ICD: '.$opd_visits_info["ICD_Text"];
								echo '</td>';
							echo '</tr>';	
							echo '<tr>';
								echo '<td colspan=4>';
									echo 'SNOMED: '.$opd_visits_info["SNOMED_Text"];
								echo '</td>';
							echo '</tr>';	
							echo '<tr>';
								echo '<td colspan=2>';
									echo 'Remarks: '.$opd_visits_info["Remarks"];
								echo '</td>';
								echo '<td >';
									echo 'CreatedBy: '.character_limiter($opd_visits_info["CreateUser"],15);
								echo '</td>';
								echo '<td >';
									if ($opd_visits_info["LastUpDateUser"] !=""){
										echo 'Last Access By: '.character_limiter($opd_visits_info["LastUpDateUser"],15);
									}
								echo '</td>';
							echo '</tr>';				
						echo '</table>';
					?>
			</div>	<!-- END OPD INFO-->
			<!-- NOTES-->
				<?php echo Modules::run('opd/get_nursing_notes',$opd_visits_info["OPDID"],'opd/view/'.$opd_visits_info["OPDID"],"HTML"); ?>

			<!-- END NOTES-->	
			<!-- ALLERGY-->
				<?php echo Modules::run('patient/get_previous_allergy',$PID,'opd/view/'.$opd_visits_info["OPDID"],"HTML"); ?>

			<!-- END ALLERGY-->			
			<!-- PAST HISTORY-->
				<?php echo Modules::run('patient/get_previous_history',$PID,'opd/view/'.$opd_visits_info["OPDID"],"HTML"); ?>
			
			<!-- END PAST HISTORY-->
			

			
			<!-- EXAMINATION-->
               <?php echo Modules::run('patient/get_previous_exams',$PID,'opd/view/'.$opd_visits_info["OPDID"],"HTML"); ?>
			<!-- END EXAMINATION-->
			<!-- LAB-->
				<?php echo Modules::run('patient/get_previous_lab',$PID,'opd/view/'.$opd_visits_info["OPDID"],"HTML"); ?>

			<!-- END LAB-->				
			<!-- END TREATMENT-->
						<!-- Ijection-->
				<?php echo Modules::run('patient/get_previous_injection',$PID,'opd/view/'.$opd_visits_info["OPDID"],"HTML"); ?>

			<!-- ENDIjection-->		
	

			<!-- PRESCRIPTION-->
			<?php
                if ((isset($patient_prescription_list))&&(!empty($patient_prescription_list))){			
					echo '<div class="panel panel-default"  style="padding:2px;margin-bottom:1px;" >';
						echo '<div class="panel-heading" ><b>Prescriptions for this visit</b></div>';
							echo '<table class="table table-condensed table-hover"  style="font-size:0.95em;margin-bottom:0px;cursor:pointer;">';
							for ($i=0;$i<count($patient_prescription_list); ++$i){
								echo '<tr onclick="self.document.location=\''.site_url("opd/prescription/".$patient_prescription_list[$i]["PRSID"]).'?CONTINUE=opd/view/'.$opd_visits_info["OPDID"].'\';">';
								echo '<td>';
								echo $patient_prescription_list[$i]["CreateDate"];
								echo '</td>';
								echo '<td>';
								echo $patient_prescription_list[$i]["PrescribeBy"];
								echo '</td>';
								echo '<td>';
								if ($patient_prescription_list[$i]["Status"] == "Dispensed"){
									echo '<span class="glyphicon glyphicon-check"></span>';
								}
								else if($patient_prescription_list[$i]["Status"] == "Pending"){
									echo '<span class="glyphicon glyphicon-time"></span>';
								}
								else{
									echo '<span class="glyphicon glyphicon-edit"></span>';
								}
								
								echo '&nbsp'.$patient_prescription_list[$i]["Status"];
								echo '</td>';
								echo '<td>';
							   // echo $patient_prescription_list[$i]["Frequency"];
								echo '</td>';
								echo '<td>';
								//echo $patient_prescription_list[$i]["HowLong"];
								echo '</td>';
								echo '<td>';
							   // echo $patient_prescription_list[$i]["Quantity"];
								echo '</td>';
								echo '</tr>';
							}
							echo '</table>';
					echo '</div>';	
				}
			?>
			<!-- END PRESCRIPTION-->		

			<!-- TREATMENT-->
			<?php
			if ((isset($patient_treatment_list))&&(!empty($patient_treatment_list))){
				echo '<div class="panel panel-default"  style="padding:2px;margin-bottom:1px;" >';
					 echo '<div class="panel-heading" ><b>Treatments</b></div>';
						echo '<table class="table table-condensed table-hover"  style="font-size:0.95em;margin-bottom:0px;cursor:pointer;">';
						for ($i=0;$i<count($patient_treatment_list); ++$i){
						   echo '<tr onclick="self.document.location=\''.site_url("form/edit/opd_treatment/".$patient_treatment_list[$i]["OPDTREATMENTID"]).'?CONTINUE=opd/view/'.$opd_visits_info["OPDID"].'\';">';
							echo '<td>';
							echo $patient_treatment_list[$i]["CreateDate"];
							echo '</td>';
							echo '<td>';
							echo $patient_treatment_list[$i]["Treatment"];
							echo '</td>';
							echo '<td>';
							echo $patient_treatment_list[$i]["Remarks"];
							echo '</td>';
							echo '<td>';
							echo $patient_treatment_list[$i]["Status"];
							echo '</td>';
							echo '</tr>';
						}
						echo '</table>';
				echo '</div>';	
			 }
			?>
		
		</div>
	</div>
</div>
