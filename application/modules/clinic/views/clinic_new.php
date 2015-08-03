<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
	echo Modules::run('menu'); //runs the available menu option to that usergroup
?>
<div class="container" style="width:95%;">
	<div class="row" style="margin-top:55px;">
	  <div class="col-md-2 ">
		<?php echo Modules::run('leftmenu/clinic_new',$clinic_id,$pid,$clinic_patient_info,$clinic_questionnaire_list); //runs the available left menu for preferance ?>
	  </div>
	  <div class="col-md-10 " >
	  <div class="panel panel-default"  style="padding-bottom:0px;">
			<div class="panel-heading"><b><?php echo $clinic_info["name"]; ?></b>
			</div>
				<?php
				$patInfo ="";
				//$mdsPermission = MDSPermission::GetInstance();
				//if ($mdsPermission->haveAccess($_SESSION["UGID"],"patient_Edit"))
				$tools = "<img src='".base_url()."/images/patient.jpg' width=100 height=100 style='padding:2px;'>";
				echo  "<div id ='patientBanner' class='well'  style='padding:0px;margin-bottom:0px'>\n";
				echo  "<table width=100% border=0 class='' style='font-size:0.95em;'>\n";
				echo  "<tr><td  rowspan=5 valign=top align=left width=10>".$tools."</td><td>Full Name:</td><td><b>";
				echo  $patient_info["Personal_Title"];
				echo  $patient_info["Personal_Used_Name"]."&nbsp;";
				echo  $patient_info["Full_Name_Registered"];
				echo "</b></td><td>HIN:</td><td><b>".$patient_info["HIN"]."</b>";
				echo  "<td  rowspan=5 valign=top align=left width=10>";
				echo  "<input type='button' class='btn btn-xs btn-warning pull-right' onclick=self.document.location='".site_url('form/edit/patient/'.$patient_info["PID"].'?CONTINUE=/clinic/open/'.$clinic_info["clinic_id"].'/'.$patient_info["PID"])."' value='Edit'>";
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
			<div class="panel panel-default"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading" ><b>Previous clinic records</b></div>
					<?php
						/*
						if ($opd_visits_info["referred_admission_id"] >0){
							echo '&nbsp;<span class="label label-info"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;This visit referred to admission </span>';
							echo '<a class="btn btn-default btn-xs" href="'.site_url("admission/view/".$opd_visits_info["referred_admission_id"]).'"> Open </a>';
						}
						*/
						//print_r($clinic_previous_record_list);
						echo '<table class="table "  style="font-size:0.95em;margin-bottom:0px;">';
							if (!empty($clinic_previous_record_list)){
								for($i=0;$i<count($clinic_previous_record_list);++$i){
									echo '<tr>';
										echo '<td>';
											echo '<b class="" style="cursor:pointer;display:block" onclick=$("#data_'.$i.'").toggle(); >Questionnaire: '.$clinic_previous_record_list[$i]["qu_name"].' '.$clinic_previous_record_list[$i]["CreateDate"].' </b><hr style="margin:0px;">';
											// By: '.$clinic_previous_record_list[$i]["CreateUser"].'
											if (!empty($clinic_previous_record_list[$i]["data"])){
												echo '<div id="data_'.$i.'" style="display:none">';
												echo '<table class="table table-condensed table-striped table-hover">';
												for($j=0;$j<count($clinic_previous_record_list[$i]["data"]);++$j){
													if ($clinic_previous_record_list[$i]["data"][$j]["answer"]=="") continue;
													echo '<tr>';
														echo '<td nowrap width=300px>';
															if($clinic_previous_record_list[$i]["data"][$j]["answer_type"] == "Footer"){
																continue;
															}
															elseif($clinic_previous_record_list[$i]["data"][$j]["answer_type"] == "Header"){
																echo '<b style="text-align:center;">'.$clinic_previous_record_list[$i]["data"][$j]["question"].'</b>';
															}
															else{
																echo $clinic_previous_record_list[$i]["data"][$j]["question"];
															}
														echo '</td>';
														echo '<td>';
															if($clinic_previous_record_list[$i]["data"][$j]["answer_type"]=="PAIN_DIAGRAM"){
																echo '<a target="_blank" href="javascript:void()" onclick=open_diagram("'.$clinic_diagram_info["clinic_diagram_id"].'","'.$patient_info["PID"].'","'.$clinic_previous_record_list[$i]["data"][$j]["qu_answer_id"].'");>Open Diagram</a>';
															}
															else{
																echo $clinic_previous_record_list[$i]["data"][$j]["answer"];
															}
														echo '</td>';
													echo '</tr>';	
												}
												echo '</table>';
												echo '</div>';
											}	
										echo '</td>';				
									echo '</tr>';				
								}	
							}
						echo '</table>';
					?>
			</div>	<!-- END OPD INFO-->
			<!-- NOTES-->
				<?php //echo Modules::run('opd/get_nursing_notes',$patient_info["PID"],'clinic/open/'.$clinic_patient_info["clinic_patient_id"],"HTML"); ?>
			<!-- END NOTES-->	
			<!-- ALLERGY-->
				<?php //echo Modules::run('patient/get_previous_allergy',$patient_info["PID"],'clinic/open/'.$clinic_patient_info["clinic_patient_id"],"HTML"); ?>
			<!-- END ALLERGY-->			
			<!-- PAST HISTORY-->
				<?php //echo Modules::run('patient/get_previous_history',$patient_info["PID"],'clinic/open/'.$clinic_patient_info["clinic_patient_id"],"HTML"); ?>
			<!-- END PAST HISTORY-->
			<!-- EXAMINATION-->
               <?php //echo Modules::run('patient/get_previous_exams',$patient_info["PID"],'clinic/open/'.$clinic_patient_info["clinic_patient_id"],"HTML"); ?>
			<!-- END EXAMINATION-->
			<!-- LAB-->
				<?php //echo Modules::run('patient/get_previous_lab',$patient_info["PID"],'clinic/open/'.$clinic_patient_info["clinic_patient_id"],"HTML"); ?>
			<!-- END LAB-->				
			<!-- END TREATMENT-->
			<!-- Ijection-->
				<?php //echo Modules::run('patient/get_previous_injection',$patient_info["PID"],'clinic/open/'.$clinic_patient_info["clinic_patient_id"],"HTML"); ?>
			<!-- ENDIjection-->		
		</div>
	</div>
</div>
<script>
	function open_diagram(diagram_id,pid,ans_id){
		var url='<?php echo site_url('diagram/view/'); ?>';
		url+='/'+diagram_id+'/'+pid+'/view_data/'+ans_id;
		var win = window.open(url,'d_win','fullscreen=yes,location=no,menubar=no');
	}
</script>
