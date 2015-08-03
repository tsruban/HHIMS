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
echo "\n<meta http-equiv='refresh' content='15' > ";
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
		<?php echo Modules::run('leftmenu/admission',$admission_info,$PID,$admission_drug_order); //runs the available left menu for preferance ?>
	  </div>
	  <div class="col-md-10 " >
	   <div class="panel panel-default"  >
			<div class="panel-heading"><b>Patient admission overview </b>
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
		echo  "<input type='button' class='btn btn-xs btn-warning pull-right' onclick=self.document.location='".site_url('form/edit/patient/'.$patient_info["PID"].'?CONTINUE=/admission/view/'.$admission_info["ADMID"])."' value='Edit'>";
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
			//print_r($opd_visits_info); 
			//print_r($this->session)?>
			<?php
			echo '<div class="panel ';
			if ($admission_info["OutCome"]){
				echo 'panel-default' ;
			}
			else{
				echo 'panel-success';
			}
			echo ' "  style="padding:2px;margin-bottom:1px;" >';
				
				echo '<div class="panel-heading" ><b>Initial admission details &nbsp;&nbsp;&nbsp;';
				if ($admission_info["OutCome"]){
					echo '[DISCHARGED]';
				}
				echo '</b></div>';
					
						echo '<table class="table table-condensed"  style="font-size:0.95em;margin-bottom:0px;">';
							echo '<tr>';
								echo '<td>';
									echo 'BHT: <b>'.$admission_info["BHT"].'</b>';
								echo '</td>';
								echo '<td>';
									echo 'Date & Time of admission: '.$admission_info["AdmissionDate"];
								echo '</td>';
								echo '<td>';
									echo 'Onset Date: '.$admission_info["OnSetDate"];
								echo '</td>';
								echo '<td>';
									echo 'Doctor: '.$admission_info["Doctor"];
									if ($admission_info["OutCome"]==""){
										echo  "<input type='button' class='btn btn-xs btn-warning pull-right' onclick=self.document.location='".site_url('form/edit/admission/'.$admission_info["ADMID"])."' value='Edit'>";
									}
								echo '</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td colspan=3>';
									echo 'Complaint: <b>'.$admission_info["Complaint"].'</b>';
								echo '</td>';
								echo '<td>';
									echo 'Ward: ';
									//print_r($admission_info);
									echo '<a href="'.site_url("ward/view/".$admission_info["WID"]).'">'.$admission_info["Ward"].'</a>';
								echo '</td>';
								
							echo '</tr>';
							if ($admission_info["OutCome"]){							
								echo '<tr>';
									echo '<td colspan=1>';
										echo 'Discharge Date: <b>'.$admission_info["DischargeDate"].'</b>';
									echo '</td>';
									echo '<td colspan=2>';
										echo 'Refer To: <b>'.$admission_info["ReferTo"].'</b>';
									echo '</td>';
									echo '<td colspan=1>';
										echo 'OutCome: <b>'.$admission_info["OutCome"].'</b>';
									echo '</td>';
									
								echo '</tr>';	
							}
							echo '<tr>';
								echo '<td colspan=2>';
									echo 'Remarks: '.$admission_info["Remarks"];
								echo '</td>';
								echo '<td >';
									echo 'CreatedBy: '.character_limiter($admission_info["CreateUser"],20);
								echo '</td>';
								echo '<td >';
									if ($admission_info["LastUpDateUser"] !=""){
										echo 'Last Access By: '.character_limiter($admission_info["LastUpDateUser"],20);
									}
								echo '</td>';
							echo '</tr>';				
						echo '</table>';
					?>
			</div>	<!-- END OPD INFO-->
			<div class="panel panel"  style="padding:2px;margin-bottom:1px;"  >
				<div class="panel-heading" style="background:#ffffff;"><b>Diagnosis</b></div>
			<?php
				//print_r($admission_diagnosis);
				if (isset($admission_diagnosis)){
						echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;" >';
						echo '<tr style="background:#e2e2e2;"><th width=150 nowrap>Date</th><th>Diagnosis</th>';
						
						echo '<th>By</th>';

						echo '</tr>';
							for($i=0; $i < count($admission_diagnosis);++$i){
							//print_r($prescribe_items_list[$i]);
								echo '<tr ';
								echo '>';
								
									echo '<td>';
									if ($admission_info["OutCome"]==""){
										echo '<a href="'.site_url("form/edit/admission_diagnosis/".$admission_diagnosis[$i]["ADMDIAGNOSISID"]."?CONTINUE=admission/view/".$admission_info["ADMID"]).'">'.$admission_diagnosis[$i]["DiagnosisDate"].'</a>';
									}
									else{
											echo $admission_diagnosis[$i]["DiagnosisDate"];
										}
									echo '</td>';
									echo '<td>';
										echo $admission_diagnosis[$i]["SNOMED_Text"];
									echo '</td>';
									echo '<td>';
										echo character_limiter($admission_diagnosis[$i]["CreateUser"],20);
									echo '</td>';
								echo '</tr>';
							}
						echo '</table>';	
				}							
			?>
			</div>
			<!-- PAST HISTORY-->
				<?php echo Modules::run('admission/get_nursing_notes',$admission_info["ADMID"],'admission/view/'.$admission_info["ADMID"],"HTML"); ?>

			<!-- END PAST HISTORY-->
			<!-- PAST HISTORY-->
				<?php echo Modules::run('patient/get_previous_history',$patient_info["PID"],'admission/view/'.$admission_info["ADMID"],"HTML"); ?>

			<!-- END PAST HISTORY-->
			
			<!-- ALLERGY-->
			<!-- END ALLERGY-->
				<?php echo Modules::run('patient/get_previous_allergy',$patient_info["PID"],'admission/view/'.$admission_info["ADMID"],"HTML"); ?>
			
			<!-- EXAMINATION-->
			<?php echo Modules::run('patient/get_previous_exams',$patient_info["PID"],'admission/view/'.$admission_info["ADMID"],"HTML"); ?>
			<!-- END EXAMINATION-->
			<!-- LAB-->
			<?php echo Modules::run('patient/get_previous_lab',$patient_info["PID"],'admission/view/'.$admission_info["ADMID"],"HTML"); ?>
			
			<!-- END LAB-->				
	
			<?php echo Modules::run('patient/get_previous_injection',$patient_info["PID"],'admission/view/'.$admission_info["ADMID"],"HTML"); ?>
	

			<!-- PRESCRIPTION-->
			<div class="panel panel"  style="padding:2px;margin-bottom:1px;"  >
				<div class="panel-heading" style="background:#ffffff;"><b>Drugs ordered for this admission</b></div>
				<?php
				//print_r($admission_drug_list);
				if (isset($admission_drug_list)){
						echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;" >';
						echo '<tr style="background:#e2e2e2;"><th>#</th><th width=150 nowrap>Date</th><th>Name</th><th>Dose</th><th>Frequency</th><th width=102>Type</th>';
						
						echo '<th>Status</th>';

						echo '</tr>';
							for($i=0; $i < count($admission_drug_list);++$i){
							//print_r($prescribe_items_list[$i]);
								echo '<tr ';
								if ($admission_drug_list[$i]["Status"] == "Discontinue"){
									echo ' style="text-decoration:line-through" ';
								}
								echo '>';
								
									echo '<td>';
										echo ($i+1);
									echo '</td>';
									echo '<td>';
										echo $admission_drug_list[$i]["CreateDate"];
									echo '</td>';
									echo '<td>';
										echo $admission_drug_list[$i]["name"];
									echo '</td>';
									echo '<td>';
										echo $admission_drug_list[$i]["Dosage"];
									echo '</td>';
									echo '<td>';
										echo $admission_drug_list[$i]["Frequency"];
									echo '</td>';
									echo '<td>';
										if( $admission_drug_list[$i]["type"] == "Once only"){
											echo '<span class="label label-danger">'.$admission_drug_list[$i]["type"].'</span>';
											if ($admission_drug_list[$i]["is_given"] ==1){
													echo '<a href="'.site_url("admission/drug_chart/".$admission_drug_order["admission_prescription_id"]."/Once%20only").'" class="glyphicon glyphicon-ok"></a>';
											}
										}
										else if( $admission_drug_list[$i]["type"] == "Regular"){
											echo '<span class="label label-success">'.$admission_drug_list[$i]["type"].'</span>';
											echo '<a href="'.site_url("admission/drug_chart/".$admission_drug_order["admission_prescription_id"]."/regular").'" class="glyphicon glyphicon-eye-open"></a>';
											
										}
										else{
											echo '<span class="label label-warning">'.$admission_drug_list[$i]["type"].'</span>';
										echo '<a href="'.site_url("admission/drug_chart/".$admission_drug_order["admission_prescription_id"]."/As-Needed").'" class="glyphicon glyphicon-eye-open"></a>';
										}
									echo '</td>';
									echo '<td width=102px>';
										//echo '<button type="button" class="btn btn-default btn-xs" title=" Remove this item" onclick=delete_record("'.$admission_drug_list[$i]["prescribe_items_id"].'"); >
												//<span class="glyphicon glyphicon-remove-circle"></span>
												//</button>';
												echo $admission_drug_list[$i]["Status"];
												/*
										echo 	'<select style="width:100px;" onchange=update_status(this.value,"'.$admission_drug_list[$i]["prescribe_items_id"].'"); >';
											echo '<option></option>';
											echo 	'<option value="Discontinue" ';
												if ($admission_drug_list[$i]["Status"] == "Discontinue"){
													echo ' selected ';
												}
											echo 	'>';
												echo 	'Discontinue';
											echo 	'</option>';
											echo 	'<option value="Continue" ';
												if ($admission_drug_list[$i]["Status"] == "Continue"){
													echo ' selected ';
												}
											echo 	'>';
												echo 	'Continue';
											echo 	'</option>';
										echo 	'</select>';
										*/
										; ;
		
									echo '</td>';
								echo '</tr>';
							}
						echo '</table>';	
				}			
				?>
			</div>	
			<!-- END PRESCRIPTION-->		

			<!-- TREATMENT-->
			<div class="panel panel-info"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading" ><b>Treatments</b></div>
			</div>	
			<!-- END TREATMENT-->
			
		</div>
	</div>
</div>
