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
	
	<div class="col-md-10 " >
		<?php
			if (isset($PID)){
				echo Modules::run('patient/banner',$PID);
			}
		?>
		<div class="panel panel-default  "  style="padding:2px;margin-bottom:1px;" >
			<div class="panel-heading" ><b>Admission lab order</b></div>
			<div class="" style="margin-bottom:1px;padding-top:8px;">
			<?php 
				//print_r($admission_info);
					echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;">';
						echo '<tr>';
							echo '<td>';
								if (isset($ward_info["Name"])){
									echo 'Ward : <b >'.$ward_info["Name"].'</b>';
								}	
							echo '</td>';
							echo '<td>';
								if (isset($admission_info["Complaint"])){
									echo 'Complaint : <b >'.$admission_info["Complaint"].'</b>';
								}	
							echo '</td>';
							echo '<td>';
								if (isset($admission_info["AdmissionDate"])){
									echo 'Admission Date : <b >'.$admission_info["AdmissionDate"].'</b>';
								}	
							echo '</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>';
								if (isset($admission_info["BHT"])){
									echo 'BHT : <b >'.$admission_info["BHT"].'</b>';
								}
							echo '</td>';						
							echo '<td>';
								if (isset($doctor_info)){
									echo 'Doctor : <b >'.$doctor_info["Title"].' '.$doctor_info["FirstName"].' ' .$doctor_info["OtherName"]. '</b>';
								}	
							echo '</td>';
							echo '<td> ';							
								if (isset($admission_info["Doctor"])){
									//echo 'Doctor : <b >'.$admission_info["Doctor"].' '.$admission_info["FirstName"].' ' .$admission_info["OtherName"]. '</b>';
								}	
							echo '</td>';
						echo '</tr>';	
						echo '<tr>';
							echo '<td>';
								echo '<b>Priority:</b>';
								if (isset($oreder_info)){
									echo $oreder_info["Priority"];
								}
								if (($mode!="view")&&($mode!="process")){
									echo '<select onchange=$("#Priority").val(this.value)  class="form-control input-sm"><option value="">...Select...</option><option value="Normal">Normal</option><option value="Urgent">Urgent</option></select>';
								}
							echo '</td>';						
							echo '<td >';							
								echo '<b>Test group:</b>';
								if (isset($oreder_info)){
									echo $oreder_info["TestGroupName"];
								}
								if (isset($test_list)){
									echo '<select onchange=load_lab_test(this.value) id="TestGroupName" name="TestGroupName" class="form-control input-sm">';
										echo '<option value="">...Select...</option>';
										foreach($test_list as $key=>$value) {
											echo '<option value="'.$value["Name"].'">'.$value["Name"].'</option>';
										}
									echo '</select>';
							
								}
							echo '</td>';
							if (isset($oreder_info)){
								echo '<td >';
									echo 'Order Date : '.$oreder_info["OrderDate"] ;
								echo '</td >';
							}	
						echo '</tr>';
					echo '</table>';		
					echo '<br><center><a href="'.site_url("admission/view/".$admid).'">Back to admission</a></center>';	
					echo '<div>';
					echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;">';
					if (isset($episode_lab_order)){
						echo '<b>Lab ordered for this visit</b>';
						foreach($episode_lab_order as $key=>$value) {
							echo '<tr>';
								echo '<td>';
									echo $value["OrderDate"];
								echo '</td>';
								echo '<td>';
									echo $value["TestGroupName"];
								echo '</td>';
								echo '<td>';
									echo $value["Status"];
								echo '</td>';
								echo '<td>';
								echo ' <a  href="'.site_url("laboratory/order/".$value["LAB_ORDER_ID"]."/?CONTINUE=laboratory/admission_order/".$admid).'">[Open]&nbsp;</a>';
								echo ' <a target="_blank" href="'.site_url("laboratory/order/".$value["LAB_ORDER_ID"]."/?CONTINUE=laboratory/admission_order/".$admid).'">[Print]&nbsp;</a>';
								echo ' <a  href="'.site_url("laboratory/process_result/".$value["LAB_ORDER_ID"]."/?CONTINUE=laboratory/admission_order/".$admid).'">[Enter result]</a>';
								echo '</td>';
								
							echo '<tr>';
						}
					}
					echo '</table>';
					echo '</div>';					
		
			?>
			<form id="order_form" method="POST" action="<?php 
				if ($mode=="process"){
					echo site_url("laboratory/save_result"); 
				}
				else {
					echo site_url("laboratory/save_order"); 
				}
			?>" >
				<?php
					if ($mode=="process"){
						echo '<input type="text" name="CONTINUE" id="CONTINUE" value="'.(isset($_GET["CONTINUE"])?$_GET["CONTINUE"]:"").'" >';
					}
					else {
						echo '<input type="hidden" name="CONTINUE" id="CONTINUE" value="'.current_url().(isset($_GET["CONTINUE"])?'/?CONTINUE='.$_GET["CONTINUE"]:'').'">';
					}
				?>	
				<input type="hidden" name="Dept" id="Dept" value="ADM">
				<input type="hidden" name="GroupName" id="GroupName" value="">
				<input type="hidden" name="Priority" id="Priority" value="">
				<input type="hidden" name="OPDID" id="OPDID" value="<?php echo $admid; ?>">
				<input type="hidden" name="PID" id="PID" value="<?php echo $patient_info["PID"]; ?>">
				<input type="hidden" name="LAB_ORDER_ID" id="LAB_ORDER_ID" value="<?php if (isset($oreder_info["LAB_ORDER_ID"])) echo $oreder_info["LAB_ORDER_ID"]; ?>">
				<div id="lab_block" >
					<div class="panel panel-default  "  style="padding:2px;margin-bottom:1px;" >
						<div class="panel-heading" id="test_head"><b>Available tests</b></div>
						<div id="lab_cont">
							<?php	
								//print_r($orederd_test_list);
								if (($mode=="view")||($mode=="process")){
									if (!empty($orederd_test_list)){
										$i=1;
										echo '<table class="table">';
										echo '<tr>';
											echo '<th width=15px>';
												echo "#";
											echo '</th>';
											echo '<th >';
												echo "Name";
											echo '</th>';
											echo '<th >';
												echo "Result";
											echo '</th>';
											echo '<th>';
												echo "Ref. value";
											echo '</th>';
										echo '</tr>';											
										foreach($orederd_test_list as $key=>$value) {
											echo '<tr>';
												echo '<td width=15px>';
													echo $i;
												echo '</td>';	
												echo '<td>';
													echo $value["Name"];
												echo '</td>';	
												if ($value["Status"] == "Pending"){
													if ($mode=="process"){
														echo '<td>';
															echo '<textarea id="'.$value["LAB_ORDER_ITEM_ID"].'"  name="'.$value["LAB_ORDER_ITEM_ID"].'"   cols=40 rows=4></textarea>';
														echo '</td>';
														echo '<td>';
															echo $value["RefValue"];
														echo '</td>';
													}
													else{
														echo '<td>';
															echo '<b class="blink_me" style="color:red">Pending .....</b>';
														echo '</td>';
													}
												}
												else{
													echo '<td>';
														echo $value["TestValue"];
													echo '</td>';				
													echo '<td>';
														echo $value["RefValue"];
													echo '</td>';																	
												}
											echo '</tr>';
											$i++;
										}
										echo '</table>';
										echo '<center>';
											if (isset($oreder_info)&&($oreder_info["Status"]=="Available")){
												echo '<button onclick=result_seen("'.$oreder_info["LAB_ORDER_ID"].'") type="button" id="btn_by_group" class="btn btn-primary btn-sm">Result seen by ' .$this->session->userdata("FullName").'</button>';
												echo '&nbsp;&nbsp;<a href="'.site_url($_GET["CONTINUE"]).'">Back to admission</a>';
											}
											else{
												if ($mode=="process"){
													echo '<input type="checkbox" class=""   id="confirm"> <b>Result confirmed by '.$this->session->userdata("FullName").'</b><br>';
													echo '<button onclick=result_save() type="button" id="btn_by_group" class="btn btn-success btn-sm">Save Result</button>';
													echo '&nbsp;&nbsp;<a href="'.site_url($_GET["CONTINUE"]).'">Back to list</a>';
												}
												else{
													echo '&nbsp;&nbsp;<a href="'.site_url($_GET["CONTINUE"]).'">Back to admission</a>';
												}	
											}
										echo '</center>';
									}
								}
							?>
						</div >
					</div>
				</div>	
			</form>
			</div>
		</div>	
	</div>
	<div class="col-md-2">

		<!-- ALLERGY-->
		<div class="panel  panel-danger"  style="padding:2px;margin-bottom:1px;" >
			<div class="panel-heading" ><b>Allergies</b></div>

		</div>	
		<!-- END ALLERGY-->
  		<div class="panel  panel-info"  style="padding:2px;margin-bottom:1px;" >
			<div class="panel-heading" ><b>Previous orders</b></div>
			<?php
				//print_r($patient_previous_lab_list);
				if (isset($patient_previous_lab_list)){
					foreach($patient_previous_lab_list as $key=>$value) {
						echo $value["TestGroupName"];
						echo ' <a onclick="load_lab_test(\''.$value["TestGroupName"].'\')"> [Repeat]</a>';
						echo '<br>';
					}
				}
			?>
		</div>	
  </div>
	</div>
</div>
<script language="javascript">
function result_save(){
	if ($("#confirm").attr("checked")!="checked"){
		alert("Please confirm the result");
		return;
	}
	$("#order_form").submit();
}
function load_lab_test(group){
	$("#lab_cont").html('');
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/laboratory/get_lab_test/"+group,
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		if (data.length>0){
			$("#lab_block").show();
			try{
				var tests = '';
				tests += '<table class="table table-condensed table-hover" >';
				for (var i=0; i<data.length; i++){
					tests += '<tr>';
						tests += '<td>';
							tests += '<input type="checkbox" checked id="'+data[i]["LABID"]+'" name="'+data[i]["LABID"]+'">';
						tests += '</td>';
						tests += '<td>';
							tests += data[i]["Name"];
						tests += '</td>';
						tests += '<td>';
							tests += data[i]["GroupName"];
						tests += '</td>';
						tests += '<td>';
							tests += data[i]["Department"];
						tests += '</td>';
					tests += '</tr>';
				}
				tests += '<tr>';
					tests += '<td colspan=4>';
						//tests += 'Sample collection Date:';
						//tests += '<input type="text" >';
					tests += '</td>';
				tests += '</tr>';
				tests += '<tr>';
					tests += '<td colspan=4 align=center>';
						tests += '<hr><button type="submit" id="btn_by_group" class="btn btn-primary btn-sm">Create order</button>';
						tests += '&nbsp;&nbsp;<a href="<?php echo site_url($_GET["CONTINUE"]); ?>">Cancel</a>';
					tests += '</td>';
				tests += '</tr>';
				tests += '</table>';
				$("#lab_cont").html(tests);
				$("#GroupName").val(group);
				
			}catch(e){
			}

		}
		else{
			$("#lab_block").show();
		}
	});
}

function init(){
	mode = '<?php echo $mode; ?>';
	if ((mode!='view')&&(mode!='process')){
		$("#lab_block").hide();
	}
	else{
		$("#lab_block").show();
		$("#test_head").html('<b>Ordered tests</b>');
	}

}
$(function(){
	init();
});


function send_to_pharmacy(id,opdid){
	if (id=="") return;
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/opd/prescription_send/"+id,
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		if (response==1){
			location.reload();
		}
	});
}
</script>