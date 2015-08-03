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
<div class="container" style="width:95%;">
	<div class="row" style="margin-top:55px;">
	  <div class="col-md-2 ">
		<?php echo Modules::run('leftmenu/opd',$OPDID,$PID); //runs the available left menu for preferance ?>
	  </div>
	  <div class="col-md-10 " >
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
		echo  "<input type='button' class='btn btn-xs btn-warning pull-right' onclick=self.document.location='".site_url('form/edit/patient/'.$patient_info["PID"])."' value='Edit'>";
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

			<?php 
			//print_r($opd_visits_info); 
			//print_r($this->session)?>
			<div class="panel panel-default"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading" ><b>Visit information</b></div>
					<?php
						echo '<table class="table table-condensed"  style="font-size:0.95em;margin-bottom:0px;">';
							echo '<tr>';
								echo '<td>';
									echo 'Type: '.$opd_visits_info["VisitType"];
								echo '</td>';
								echo '<td>';
									echo 'Date & Time of visit: '.$opd_visits_info["DateTimeOfVisit"];
								echo '</td>';
								echo '<td>';
									echo 'Onset Date: '.$opd_visits_info["OnSetDate"];
								echo '</td>';
								echo '<td>';
									echo 'Doctor: '.$opd_visits_info["Doctor"];
									echo  "<input type='button' class='btn btn-xs btn-warning pull-right' onclick=self.document.location='".site_url('form/edit/opd_visits/'.$opd_visits_info["OPDID"])."' value='Edit'>";
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
									echo 'CreatedBy: '.$opd_visits_info["CreateUser"].'('.$opd_visits_info["CreateDate"].')';
								echo '</td>';
								echo '<td >';
									if ($opd_visits_info["LastUpDateUser"] !=""){
										echo 'Last Access By: '.$opd_visits_info["LastUpDateUser"].'('.$opd_visits_info["LastUpDate"].')';
									}
								echo '</td>';
							echo '</tr>';				
						echo '</table>';
					?>
			</div>	<!-- END OPD INFO-->
			<!-- PAST HISTORY-->
			<div class="panel panel-info"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading" ><b>Past history</b></div>
			</div>	
			<!-- END PAST HISTORY-->
			
			<!-- ALLERGY-->
			<div class="panel  panel-danger"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading" ><b>Allergies</b></div>
				<?php
					//print_r($patient_allergy_list);
					if ((!isset($patient_allergy_list))||(empty($patient_allergy_list))){
						echo " - NO DATA - ";
					}
					else{
						echo '<table class="table table-condensed table-hover"  style="font-size:0.95em;margin-bottom:0px;cursor:pointer;">';
						for ($i=0;$i<count($patient_allergy_list); ++$i){
							echo '<tr onclick="self.document.location=\''.site_url("form/edit/patient_alergy/".$patient_allergy_list[$i]["ALERGYID"]).'?CONTINUE=opd/view/'.$opd_visits_info["OPDID"].'\';">';
								echo '<td>';
									echo $patient_allergy_list[$i]["CreateDate"];
								echo '</td>';
								echo '<td>';
									echo $patient_allergy_list[$i]["Name"];
								echo '</td>';
								echo '<td>';
									if ($patient_allergy_list[$i]["Status"]=="Current"){
										echo '<span class="label label-danger">'.$patient_allergy_list[$i]["Status"].'</span>';
									}
									else{
										echo '<span class="label label-warning">'.$patient_allergy_list[$i]["Status"].'</span>';
									}
								echo '</td>';
								echo '<td>';
									echo $patient_allergy_list[$i]["Remarks"];
								echo '</td>';
							echo '</tr>';
						}
						echo '</table>';
					}
				?>
			</div>	
			<!-- END ALLERGY-->
			
			<!-- EXAMINATION-->
			<div class="panel panel-info"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading" ><b>Examinations</b></div>
			</div>	
			<!-- END EXAMINATION-->
			<!-- LAB-->
			<div class="panel panel-info"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading" ><b>Lab Orders</b></div>
			</div>	
			<!-- END LAB-->				
	
	

			<!-- PRESCRIPTION-->
			<div class="panel panel-info"  style="padding:2px;margin-bottom:1px;" >
				<div class="panel-heading" ><b>Prescriptions</b></div>
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
