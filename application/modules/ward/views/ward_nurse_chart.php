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
<div  style="width:95%;">
	<div class="row" style="margin-top:55px;">
	  <div class="col-md-12 ">
			<div class="panel panel-default"  >
				<div class="panel-heading">
					<center><h4>Nurse's Drug Chart</h4></center>
					<table width=100%>
						<tr>
							<td>Hospital: <b><?php echo $this->session->userdata("Hospital"); ?></b></td>
							<td>Ward: <b><a href="<?php echo site_url("ward/view/".$ward_info["WID"]); ?>"><?php echo $ward_info["Name"]; ?></a></b></td>
							<td>Date: <b><input readonly value='<?php echo date("Y-m-d"); ?>' id="given_date"></b></td>
						</tr>
					</table>	
				</div>
				<div>
					<table width=100% class="table table-striped" >
						<tr>
							<th>#</th>
							<th>Patient/Medication</th>
						</tr>
						<?php 
						if (!empty($patient_list)){
							for ($p=0; $p < count($patient_list); ++$p){
								echo '<tr>';
									echo '<td width=10px>'.($p+1);
									echo '</td>';
									echo '<td width=100%><b>'.$patient_list[$p]["HIN"].' / '.$patient_list[$p]["patient_name"].'';
									echo ' / '.$patient_list[$p]["Gender"].' / '.$patient_list[$p]["DateOfBirth"].'</b>';
									echo ' <br><a target="_blank" href="'.site_url("admission/view/".$patient_list[$p]["ADMID"]).'"> [ BTH: '.$patient_list[$p]["BHT"].' ] '.$patient_list[$p]["Complaint"].'</a>';
									if (!empty($prescribe_items_list[$patient_list[$p]["admission_prescription_id"]])){
										echo '<table width=100% class="table table-striped table-hover">';
											for ($i=0; $i < count($prescribe_items_list[$patient_list[$p]["admission_prescription_id"]]); ++$i){
												echo '<tr>';
													echo '<td width=10px>'.($i+1);
													echo '</td>';
													echo '<td width=500px nowrap>'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["name"];
													echo '-'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["formulation"];
													echo '-'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["dose"];
													if ($prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["Status"] == "Discontinue"){
														echo ' / <span class="label label-danger">'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["Status"].'</span>';
													}
													
													echo '</td>';
													echo '<td width=10px>';
														echo $prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["Dosage"];
													echo '</td>';
													echo '<td width=100px nowrap>';
													if ($prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["type"] == "Regular"){
														echo '<span class="label label-success">'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["type"].'</span>';
													}
													else if($prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["type"] == "Once only"){
														echo '<span class="label label-danger">'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["type"].'</span>';
													}
													else{
													echo '<span class="label label-warning">'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["type"].'</span>';
													}
													echo '</td>';
													//$dispence_data = Modules::run('admission/dispence_data',$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["prescribe_items_id"]);
													//print_r($dispence_data );
													$hrs = $this->config->item('regular_hours');
													for ($h=0; $h<count($hrs); ++$h){
														echo '<td width=20px>';
														
														echo '<span class="label ';
														if (is_drug_given($hrs[$h],$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["dispence_info"]) == 1){
															echo ' label-info" ';
														}
														else{
															echo ' label-default" ';
														}	
														echo ' style="cursor:pointer" time="'.$hrs[$h].'" role="pop" pi="p_'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["prescribe_items_id"].'" ';
														 echo ' html="true" ';
														 echo ' data-container="body" ';
														 echo ' data-toggle="popover" ';
														 echo ' data-placement="bottom" ';
														 if ($prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["type"] == "Regular"){
															echo ' data-original-title="Regular Therapy" ';
														 }
														 else if ($prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["type"] == "Once only"){
															echo ' data-original-title="Once only" ';
														 }
														 else{
															echo ' data-original-title="As required therapy" '; 
														 }
														 echo ' data-content="';
																echo $prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["name"];
																echo '-'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["formulation"];
																echo '-'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["dose"];
																echo ' <br>Dosage: '.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["Dosage"];
																echo ' <br>Given at : '.$hrs[$h].' ';
																if (is_drug_given($hrs[$h],$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["dispence_info"]) == 1){
																	echo ' hrs ';
																}
																else{
																	echo ' <input type=\'hidden\' id=\'given_time_'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["prescribe_items_id"].'\' value=\''.$hrs[$h].'\'>';
																	echo '<select ';
																	echo ' id=\'is_given_'.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["prescribe_items_id"].'\'>';
																	echo '<option ></option>';
																	echo '<option value=1>Yes</option>';
																	//echo '<option value=0>No</option>';
																	echo '</select><br>';
																	echo '<button class=\'btn btn-primary btn-sm\' onclick=update_drug_required(\''.$prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["prescribe_items_id"].'\');>Update</button>';
																	}
															echo '" ';
														 echo ' data-original-title="" ';
														 echo ' title=""';
														echo '>'.$hrs[$h].'</span>';
														//print_r($prescribe_items_list[$patient_list[$p]["admission_prescription_id"]][$i]["dispence_info"]);
														echo '</td>';
													}
												echo '</tr>';
											}
										echo '</table>';
									}
									echo '</td>';
								echo '</tr>';
								
							}
						}
						//print_r($prescribe_items_list);
						?>
					</table>	
				
				<div>
			</div>
		</div>
	</div>
</div>
<script>
<?php
function is_drug_given($hrs,$dispence_data){
	if (empty($dispence_data)) return 0;
	
	$sts=0;
	for ($i=0; $i<count($dispence_data); ++$i){
		$t = explode(" ", $dispence_data[$i]["given_date_time"]);
		$th = explode(":", $t[1]);
		if ($th[0]==$hrs){
			$sts=1;
			break;
		}
	}
	return $sts;

}
?>
$(function(){
	$("[role='pop']").popover({"html":true});
});

function update_drug_required(id){
	if (id=="") return;
	
	var is_given = $("#is_given_"+id).val();
	if (is_given=="") {
		alert("Is the drug given?");
		return;
	}
	var given_date = $("#given_date").val();
	var given_time = $("#given_time_"+id).val();
	var data = {"prescribe_items_id":id, 
				"is_given":is_given, 
				"given_date":given_date,
				"given_time":given_time};
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/admission/update_only_required/",
		type: "post",
		data:data
	});
	request.done(function (response, textStatus, jqXHR){
		location.reload();
	});
}
</script>