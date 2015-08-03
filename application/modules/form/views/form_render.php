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
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/
	include_once("header.php");	///loads the html HEAD section (JS,CSS)
	echo Modules::run('menu'); //runs the available menu option to that usergroup
	?>
	<div class="container" style="width:95%;">
	
		<div class="row" style="margin-top:55px;">
		  <div class="col-md-8 col-md-offset-1 ">
			<?php 
						//die(print_r($value));
				if (set_value("PID")>0){
					echo Modules::run('patient/banner',set_value("PID"));
				}
				else if(isset($value["PID"])&&($value["PID"]!="")){
					echo Modules::run('patient/banner',$value["PID"]);
				}
				else{
					if (isset($form["PATIENT_BANNER_ID"])&&($form["PATIENT_BANNER_ID"]>0)){
						echo Modules::run('patient/banner',$form["PATIENT_BANNER_ID"]);
					}
				}
			?>	
			 <div class="panel panel-default">
				  <div class="panel-heading">
					<h3 class="panel-title"><span id="is_edited"></span><?php 
					if (isset($form["FORM_CAPTION"])){
						echo ucfirst($form["FORM_CAPTION"]); 
					}
					else{
						echo ucfirst($form["TABLE"]); 
					}
					?>
					</h3>
				  </div>
				
				  <div class="panel-body">
				
						<?php
					
						if(isset($form["EDIT_DISCRIPTION"])){
							echo '<div class="alert alert-warning"><b>Warning:</b>'.$form["EDIT_DISCRIPTION"].'</div>';
						}
				//form				
						echo '<form id="hhims_form" class="form-horizontal" role="form" ';
					
						if ($form["SAVE"] != ""){	
							echo ' action="'.base_url().'index.php/'.$form["SAVE"].'" ';
						}
						else{
							echo ' action="'.base_url().'index.php/'.'form/save/'.$form["TABLE"].'" ';
						}
						echo ' method="post" accept-charset="utf-8" enctype="multipart/form-data"  onsubmit="block_save()" >';				
						
						
						for ( $i=0; $i < count($form["FLD"]); ++$i ){
								echo '<div class="form-group">';
								echo '<div class="row">';
								  echo '<div class="col-xs-3 col-md-3" style="width:220px;">';
									if ($form["FLD"][$i]["type"] != "hidden"){
										echo '<label for="'.$form["FLD"][$i]["id"].'" class="control-label pull-right">'.form_label($form["FLD"][$i]["label"],$form["FLD"][$i]["id"]).'</label>';
									}
								  echo '</div>';
								echo '<div class="col-xs-8 col-md-8">';
							
								//die(print_r( $value[$form["FLD"][$i]["name"]]));
										if (isset($value)){
											$form_id = set_value($form["OBJID"],$value[$form["OBJID"]]);
										}
										else{
											$form_id = set_value($form["OBJID"]);
										}

										if ($form["FLD"][$i]["type"] === "select"){
											$d_value = null;
											if (isset($value)){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											echo my_form_dropdown($form["FLD"][$i], $form["FLD"][$i]["option"],$d_value,$form_id);			
										}
										else if ($form["FLD"][$i]["type"] === "table_select"){
											$d_value = null;
											if (isset($value)){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											echo my_form_table_select($form["FLD"][$i], $$form["FLD"][$i]["id"],$d_value,$form_id);			
										}
										else if ($form["FLD"][$i]["type"] === "age"){
											my_form_age($form["FLD"][$i]);
										}
										else if ($form["FLD"][$i]["type"] === "boolean"){
											$d_value = null;
											if (isset($value)){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											else{
												$d_value=$form["FLD"][$i]["value"];
											}
											echo my_form_boolean($form["FLD"][$i],array("1"=>"Yes","0"=>"No"),$d_value,$form_id);			
										}
										else if ($form["FLD"][$i]["type"] === "remarks"){
											$d_value = null;
											if (isset($value)){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											echo my_form_textarea($form["FLD"][$i],$d_value,$form["OBJID"]);			
										}
										else if ($form["FLD"][$i]["type"] === "date"){
											$d_value = null;
											if (isset($value)){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											else{
												$d_value =$form["FLD"][$i]["value"];
											}
											echo my_form_date($form["FLD"][$i],$d_value,$form_id);				
										}
										else if ($form["FLD"][$i]["type"] === "timestamp"){
											$d_value = null;
											if (isset($value)){
												if (!$value[$form["FLD"][$i]["name"]]){
													//$d_value = $value[$form["FLD"][$i]["name"]];
												}else{
													$d_value =date("Y-m-d H:i:s");
												}
											}
											else{
												$d_value =date("Y-m-d H:i:s");
											}
											echo my_form_timestamp($form["FLD"][$i],$d_value,$form_id);				
										}
										else if ($form["FLD"][$i]["type"] === "text_default"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}
											echo my_form_text_control($form["FLD"][$i],$d_value,$form_id);								
										}
										else if ($form["FLD"][$i]["type"] === "file"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}
											echo my_form_file($form["FLD"][$i],$d_value,$form_id);								
										}
										else if ($form["FLD"][$i]["type"] === "SNOMED"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}
											echo my_form_SNOMED($form["FLD"][$i],$d_value,$form_id);								
										}
										
										else if ($form["FLD"][$i]["type"] === "SNOMED_DIAGNOSIS"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}
											echo my_form_SNOMED_diagnosis($form["FLD"][$i],$d_value,$form_id);								
										}
////////icd_lookup										
										else if ($form["FLD"][$i]["type"] === "icd_lookup"){
											
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}
											echo my_form_ICD($form["FLD"][$i],$d_value,$form_id);								
										}
										else if ($form["FLD"][$i]["type"] === "complaint_lookup"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}
											echo my_form_complaint_lookup($form["FLD"][$i],$d_value,$form_id);
							
										}
										else if ($form["FLD"][$i]["type"] === "village"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}
											echo my_form_village_lookup($form["FLD"][$i],$d_value,$form_id);								
										}
										else if ($form["FLD"][$i]["type"] === "bed_head"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = Modules::run('hospital/get_current_bht');
											}

											echo my_form_bed_head($form["FLD"][$i],$d_value,$form_id);								
										}
										else if($form["FLD"][$i]["type"] === "password"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}

											echo my_form_password($form["FLD"][$i],$d_value,$form_id);
										}
										else if($form["FLD"][$i]["type"] === "object"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}
											$obj = $$form["FLD"][$i]["id"];
											echo my_form_object($form["FLD"][$i],$d_value,$form_id,$obj["name"]);
										}
										else if($form["FLD"][$i]["type"] === "label"){
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}

											echo '<b  class="form-control input-sm">'.$d_value.'</b>';								
										}										
										else{
											$d_value = null;
											if (isset($value[$form["FLD"][$i]["name"]])){
												$d_value = $value[$form["FLD"][$i]["name"]];
											}
											if ($d_value  == ""){
												$d_value  = $form["FLD"][$i]["value"];
											}

											echo my_form_text($form["FLD"][$i],$d_value,$form_id);

										}
								
										
								echo '</div>';
								echo '</div>';
								echo ' </div>';
							}
							
							
							echo '<div class="form-group">';
								echo '<div class="row">';
								  echo '<div class="col-xs-3 col-md-3">';
								  echo '</div>';
								echo '<div class="col-xs-8 col-md-8">';
									$d_value = null;
									if (isset($value)){
											$d_value =$value;	
									}
									
									echo my_form_id($form,$d_value);
									//$data_submit = array('name' => 'Save','id'=> 'SaveBtn','value' => 'Save','class'=> 'btn btn-primary' );
									//echo form_submit($data_submit);
									echo "<strong>Fields marked with an asterisk must be filled</strong><br/><br/>";
									echo '<button type="submit" name="Save" id="SaveBtn" value="Save" class="btn btn-primary ">';
									echo '<span class="glyphicon glyphicon-floppy-disk"></span> Save';
									echo '</button>';
									echo "&nbsp;";
									$data_clear = array('type'=>'button','name' => 'Cancel','id'=> 'Cancel','value' => 'Cancel','class'=> 'btn btn-default','onclick'=>'go_cancel()' );
									echo form_input($data_clear);
									if (($this->session->userdata('UserGroup') === 'Programmer')){
										//echo '<span style="float:right;color:red	;">'.anchor('form/delete/'.$form["TABLE"].'/'.$id,'Delete this').'</span>';
									}
									echo "<br><br>";
									if (isset($form["ADDITIONAL_BUTTONS"])){
										//print_r($form["ADDITIONAL_BUTTONS"]);
										for($k=0; $k<count($form["ADDITIONAL_BUTTONS"]);++$k){
											echo '<input type="hidden" name="'.$form["ADDITIONAL_BUTTONS"][$k]["id"].'" value="'.$form["ADDITIONAL_BUTTONS"][$k][$form["ADDITIONAL_BUTTONS"][$k]["id"]].'">';
											echo '<button type="submit" name="'.$form["ADDITIONAL_BUTTONS"][$k]["name"].'" id="'.$form["ADDITIONAL_BUTTONS"][$k]["name"].'" value="'.$form["ADDITIONAL_BUTTONS"][$k]["id"].'" class="btn btn-default btn-sm">';
											echo $form["ADDITIONAL_BUTTONS"][$k]["value"];
											echo '</button>';
											echo "&nbsp;";
										}
									}
							echo '</div>';
								echo '</div>';
								echo ' </div>';
								echo ' </form>';
						?>	
				  </div> 
			</div>
				  
		  </div>
		  	<div class="col-md-3"><!-- LEFT-->
			<?php 
				if (isset($left_bar)){
					for ($i=0;$i<count($left_bar);++$i){
						echo '<div class="panel  panel-danger"  style="padding:2px;margin-bottom:1px;" >';
							echo '<div class="panel-heading" ><b>'.$left_bar[$i]["title"].'</b></div>';
							echo Modules::run($left_bar[$i]["run_function"],$left_bar[$i]["param"]);
						echo '</div>';
					}
				}
			?>
			
			</div><!-- END LEFT-->
		</div>
		
  </div>
  <script>
  var is_form_edited  = false;
  var is_confirm = "<?php echo $this->config->item('save_confirm'); ?>";
  function form_update(){
	  var request = $.ajax({
			url: "<?php echo base_url(); ?>index.php/lookup/get_ICD_code/"+$("#SNOMED_Code").val(),
			type: "post"
		});
		request.done(function (response, textStatus, jqXHR){
			if (response){
				update_ICD(response);
			}
		});
	};	
	function update_ICD(icd_code){
	 var request = $.ajax({
			url: "<?php echo base_url(); ?>index.php/lookup/get_ICD_info/"+icd_code,
			type: "post"
		});
		request.done(function (response, textStatus, jqXHR){
			if (response){
				var data = eval('('+response+')');
				//{"ICDID":"590","Code":"H31","Name":"Other disorders of choroid","isNotify":"0","Remarks":null,"CreateDate":"2011-04-05 17:09:43","CreateUser":"TS Ruban","LastUpDate":null,"LastUpDateUser":null,"Active":"1"}
				$("#ICD_Code").val(data["Code"]);
				$("#ICD_Text").val(data["Name"]);
			}
		});
	
	}	
	function go_cancel(){
		if (($("#CONTINUE").val()== "")||($("#CONTINUE").val() == undefined)){
			window.history.back(0);
		}
		else{
			window.location="<?php echo base_url();?>/index.php/"+$("#CONTINUE").val();
		}
	}
	function block_save(){
		$("#SaveBtn").html("Saving....").attr("disabled","true");
	}
	$(function(){
		$("#SaveBtn").mousedown(function(){
			is_confirm = false;
			console.log(is_confirm);
		});
		$("input").on("input", function() {
			is_form_edited =true;
			$("#is_edited").html('<span class="glyphicon glyphicon-asterisk"></span>');
		});
		$("textarea").on("input", function() {
			is_form_edited =true;
			$("#is_edited").html('<span class="glyphicon glyphicon-asterisk"></span>');
		});
		$("select").on("change", function() {
			is_form_edited =true;
			$("#is_edited").html('<span class="glyphicon glyphicon-asterisk"></span>');
		});
		window.onbeforeunload = function(){
			console.log(is_confirm);
			if ((is_form_edited)&&(is_confirm)){
				return "There are some un-saved data. Do you want to continue?";
			}
		}
	});

	
	
  </script>
<?php
	
	echo '<script language="javascript">';
		echo 'function block_save(){$("#SaveBtn").val("Saving....").attr("disabled","true");}';
	echo '</script>';
 $GLOBALS['form']  = $form;	
function my_form_date($frm,$value=NULL,$fid=null){

	echo '<input  class="form-control input-sm"';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="text" ';
		}

		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		

		if (!empty($frm["can_edit"])){
			if ($fid>0){
				if(!got_access($frm["can_edit"])){
					echo ' readonly=true ';
				}	
			}
			else{
				if (isset($frm["onmousedown"])){
					echo 'onmousedown="'.$frm["onmousedown"].'" ';
				}
			}
		}
		echo 'onmousedown="'.$frm["onmousedown"].'" ';
	echo ' >';
	if (isset($frm["option"])){
			$dob = set_value($frm["name"],$value);
			if ($dob!=""){
				$age = get_age($dob);
				echo '<script>';
				echo '$(document).ready(function(){ $("#year").val("'.$age["years"].'"); $("#month").val("'.$age["months"].'"); $("#day").val("'.$age["days"].'"); })';
				echo '</script>';
			}
	}
	echo form_error($frm["name"]);		
}
function my_form_timestamp($frm,$value=NULL,$fid=null){

	echo '<input  class="form-control input-sm"';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="text" readonly=';
		}

		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}
		
	echo ' >';
	echo form_error($frm["name"]);		
}

function my_form_password($frm,$value=NULL,$fid=null){
	if ($fid>0){
		
		Modules::run('user/current_user',$fid);
		echo '<a class="btn btn-danger btn-sm" href="'.site_url('user/reset').'">****Reset password****</a>';
		return;
	}
	echo '<input  class="form-control input-sm"';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="password" ';
		}

		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}
		if (!empty($frm["can_edit"])){
			if ($fid>0){
				if(!got_access($frm["can_edit"])){
					echo ' readonly=true ';
				}	
			}
		}
	echo ' >';
	echo '<input  class="form-control input-sm" ';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="password" ';
		}

		echo 'id="Password_check" ';
		echo 'name="Password_check" ';
		echo 'value="" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="Password confirmation" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}
		if (!empty($frm["can_edit"])){
			if ($fid>0){
				if(!got_access($frm["can_edit"])){
					echo ' readonly=true ';
				}	
			}
		}
	echo ' >';
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);		
}

function my_form_text($frm,$value=NULL,$fid=null){

	echo '<input  class="form-control input-sm"';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="text" ';
		}

		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}
		if (!empty($frm["can_edit"])){
			if ($fid>0){
				if(!got_access($frm["can_edit"])){
					echo ' readonly=true ';
				}	
			}
		}
		if (isset($frm["option"])){
			echo $frm["option"];
		}
	echo ' >';

	echo form_error($frm["name"]);		
}


function my_form_object($frm,$value=NULL,$fid=null,$text){

	echo '<input  class="form-control input-sm"';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="text" ';
		}

		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.$text.'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}

		echo ' readonly=true ';
	echo ' >';
	echo ' <input type="hidden" id="'.$frm["id"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		echo 'name="'.$frm["name"].'" />';
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);		
}


function my_form_bed_head($frm,$value=NULL,$fid=null){

	echo '<input  class="form-control input-sm"';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="text" ';
		}

		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}
		if (!empty($frm["can_edit"])){
			if ($fid>0){
				if(!got_access($frm["can_edit"])){
					echo ' readonly=true ';
				}	
			}
		}
	echo ' >';
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);		
}
																				
function my_form_complaint_lookup($frm,$value=NULL,$fid=null){

	echo '<input  class="form-control input-sm"';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="text" ';
		}
		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';		
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}
		if (!empty($frm["can_edit"])){
			if ($fid>0){
				if(!got_access($frm["can_edit"])){
					echo ' readonly=true ';
				}	
			}
		}
	
	echo ' >';
	echo '<script>';
	// Modification when coding the PP configuration
	// Change the script so we can add one or many complaints in the same textfield
echo 'function split( val ) {';
	echo 'return val.split( /,\s*/ );';
echo '}';
 echo 'function extractLast( term ) {';
	echo 'return split( term ).pop();';
echo '}';
	echo '$(function() {';	 
		echo '$( "#'.$frm["id"].'" )';
		echo ' .bind( "keydown", function( event ) {
if ( event.keyCode === $.ui.keyCode.TAB &&
$( this ).autocomplete( "instance" ).menu.active ) {
event.preventDefault();
}
})';
		echo'.autocomplete({';
		  echo ' source: function( request, response ) {
$.getJSON( "'.base_url().'index.php/lookup/complaint/", {
term: extractLast( request.term )
}, response );
},';
		  echo 'minLength: 2,';
		  echo 'select: function( event, ui ) {';
		 	echo 'var terms = split( this.value );';
			 // remove the current input
			echo 'terms.pop();';
			// add the selected item
			echo 'terms.push( ui.item.value );';
			// add placeholder to get the comma-and-space at the end
			echo 'terms.push( "" );';
			echo 'this.value = terms.join( ", " );';
			echo 'return false;';
			
		  echo '}';
		echo '});';
	echo '});';
	echo '</script>';	
	
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);		
}

function my_form_village_lookup($frm,$value=NULL,$fid=null){

	echo '<input  class="form-control input-sm"';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="text" ';
		}

		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}
		if (!empty($frm["can_edit"])){
			if ($fid>0){
				if(!got_access($frm["can_edit"])){
					echo ' readonly=true ';
				}	
			}
		}
	echo ' >';
	echo '<script>';	
	echo '$(function() {';	 
		echo '$( "#'.$frm["id"].'" ).autocomplete({';
		  echo 'source: "'.base_url().'index.php/lookup/village/",';
		  echo 'minLength: 2,';
		  echo 'select: function( event, ui ) {';
			echo '$("#Address_District").val(ui.item.Address_District);';
			echo '$("#Address_DSDivision").val(ui.item.Address_DSDivision);';
		  echo '}';
		echo '});';
	echo '});';
	echo '</script>';	
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);		
}
function got_access($ug_list){
	return Modules::run('security/check_access_for_edit',$ug_list);
}
function my_form_SNOMED($frm,$value=NULL,$fid=null){

	echo '<div id="" ><table width=100%><tr><td width=30%>';
		echo '<select multiple  size="4" class="form-control input-sm"  id="snomed_select" style="height:80px;" onchange="lookUpSNOMED(\'SNOMED_Text\',$(\'#snomed_select\').val(),\'\');">';
                    echo '<option value="disorder">Disorder</option> ';
                    echo '<option value="event">Event</option> ';
                    echo '<option value="finding">Finding</option> ';
                    echo '<option value="procedures">Procedure</option>';
       echo ' </select>';
	echo '</td><td valign=top>';
	//echo '<input type="hidden" name="SNOMED_Code" id="SNOMED_Code" >';
	echo '<textarea name="SNOMED_Text" id="SNOMED_Text" class="form-control input-sm"  style="height:80px;">'.$value.'</textarea>';
	//echo '<button type="button" class="btn btn-default btn-sm">
		//	<span class="glyphicon glyphicon-thumbs-up pull-right" ';
	//echo '></span></button>';
	echo '</td></tr></table></div>';
	 echo '<div class="modal fade" id="snomedDiv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog">';
      echo '<div class="modal-content">';
        echo '<div class="modal-header">';
          echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
          echo '<h4 class="modal-title">SNOMED Search</h4>';
        echo '</div>';
        echo '<div class="modal-body" id="snomed_search">';

        echo '</div>';
        
      echo '</div><!-- /.modal-content -->';
    echo '</div><!-- /.modal-dialog -->';
  echo '</div><!-- /.modal -->';
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);

	echo '<script>';
		echo 'function lookUpSNOMED(el_id, type, txt) {';
			echo 'var request = $.ajax({';
				echo 'url : "'.base_url().'index.php/lookup/snomed/?el_id="+el_id+"&type="+type+"",';
				echo 'global : false,';
				echo 'type : "POST",';
				echo 'async : false';
			echo '}).responseText;';
			echo '$("#snomedDiv").modal();';
			echo '$("#snomed_search").html(request);';

		echo '}';
	echo '</script>';
}

function my_form_SNOMED_diagnosis($frm,$value=NULL,$fid=null){

	echo '<div id="" ><table width=100%><tr><td width=30%>';
		echo '<select multiple  size="2" class="form-control input-sm"  id="snomed_select" style="height:80px;" onchange="lookUpSNOMED(\'SNOMED_Text\',$(\'#snomed_select\').val(),\'\');">';
                    echo '<option value="disorder">Diagnosis</option> ';
                    echo '<option value="finding">Finding</option> ';
       echo ' </select>';
	echo '</td><td valign=top>';
	//echo '<input type="hidden" name="SNOMED_Code" id="SNOMED_Code" >';
	echo '<textarea name="SNOMED_Text" id="SNOMED_Text" class="form-control input-sm"  style="height:80px;">'.$value.'</textarea>';
	//echo '<button type="button" class="btn btn-default btn-sm">
		//	<span class="glyphicon glyphicon-thumbs-up pull-right" ';
	//echo '></span></button>';
	echo '</td></tr></table></div>';
	 echo '<div class="modal fade" id="snomedDiv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog">';
      echo '<div class="modal-content">';
        echo '<div class="modal-header">';
          echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
          echo '<h4 class="modal-title">SNOMED Search</h4>';
        echo '</div>';
        echo '<div class="modal-body" id="snomed_search">';

        echo '</div>';
        
      echo '</div><!-- /.modal-content -->';
    echo '</div><!-- /.modal-dialog -->';
  echo '</div><!-- /.modal -->';
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);

	echo '<script>';
		echo 'function lookUpSNOMED(el_id, type, txt) {';
			echo 'var request = $.ajax({';
				echo 'url : "'.base_url().'index.php/lookup/snomed/?el_id="+el_id+"&type="+type+"",';
				echo 'global : false,';
				echo 'type : "POST",';
				echo 'async : false';
			echo '}).responseText;';
			echo '$("#snomedDiv").modal();';
			echo '$("#snomed_search").html(request);';

		echo '}';
	echo '</script>';
}

function my_form_ICD($frm,$value=NULL,$fid=null){
	echo '<div id="" >';
		
		//echo '<input type="text" class="form-control input-sm" name="ICD_Code" id="ICD_Code" style="width:60px;" disabled>';
		echo '<input type="text" class="form-control input-sm p" name="ICD_Text" id="ICD_Text" 	value="'.$value.'" onclick="lookUpICD(\'ICD_Text\',\'\');" >';
	//echo '<button type="button" class="btn btn-default btn-sm">
		//	<span class="glyphicon glyphicon-thumbs-up pull-right" ';
	//echo '></span></button>';
	
		echo '</div>';
		 echo '<div class="modal fade" id="icdDiv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
	    echo '<div class="modal-dialog">';
	      echo '<div class="modal-content">';
	        echo '<div class="modal-header">';
	          echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
	          echo '<h4 class="modal-title">ICD Search</h4>';
	        echo '</div>';
	        echo '<div class="modal-body" id="icd_search">';
	
	        echo '</div>';
	        
	      echo '</div><!-- /.modal-content -->';
	    echo '</div><!-- /.modal-dialog -->';
	  echo '</div><!-- /.modal -->';
		if (isset($frm["option"])){
			
		}
		echo form_error($frm["name"]);

			//Modification when coding PP configuration
			//Regarding the complaints given, only the linked ICDCode will be loaded
			
				echo '<script>';
				echo 'function lookUpICD(el_id,  txt) {';
				echo 'var complaint = $("#Complaint").val();'; //
				echo 'var request = $.ajax({';
				echo 'url : "'.base_url().'index.php/lookup/icd/?el_id="+el_id+"&type=icd10&complaint="+complaint+"",'; 
				echo 'global : false,';
				echo 'type : "POST",';
				echo 'async : false';
				echo '}).responseText;';
				echo '$("#icdDiv").modal();';
				echo '$("#icd_search").html(request);';
				echo '}';
				echo '</script>';
	
}



function my_form_file($frm,$value=NULL,$fid=null){

	echo '<input  class="form-control input-sm" ';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="file" ';
		}
		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		
		
	echo ' >';
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);		
}

function my_form_text_control($frm,$value=NULL,$fid=null){

	echo '<table width=100%><tr><td><input  class="form-control input-sm" ';
		if ($frm["type"]=='hidden'){		
			echo ' type="hidden" ';
		}		
		else{
			echo ' type="text" ';
		}
		echo 'id="'.$frm["id"].'" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'value="'.set_value($frm["name"],$value).'" ';
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["class"])){ 
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}		
		if (isset($frm["maxlength"])){		
			echo 'maxlength="'.$frm["maxlength"].'" ';
		}		
		
		
	echo ' ></td><td width=10px>';
	echo '<button type="button" class="btn btn-default btn-sm">
				
			<span class="glyphicon glyphicon-thumbs-up pull-right" ';
	if (isset($frm["onmousedown"])){
			echo 'onmousedown="'.$frm["onmousedown"].'" ';
		}
	echo '></span></button></td></tr></table>';
	if (isset($frm["option"])){
		
	}
	echo form_error($frm["name"]);		
}
function my_form_textarea($frm,$value=NULL,$fid=null){
	echo '<textarea  class="form-control input-sm"   onKeyUp="getCannedText(this)" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'id="'.$frm["id"].'" ';
		if (isset($frm["cols"])){
			echo 'cols="'.$frm["cols"].'" ';
		}
		if (isset($frm["rows"])){
			echo 'rows="'.$frm["rows"].'" ';
		}
		if (isset($frm["option"])){
			echo 'option="'.$frm["option"].'" ';
		}
		if (isset($frm["placeholder"])){
			echo 'placeholder="'.$frm["placeholder"].'" ';
		}
		if (isset($frm["rules"])){		
			echo 'rules="'.$frm["rules"].'" ';
		}
		if (isset($frm["class"])){	
			echo 'class="'.$frm["class"].'" ';
		}
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
	echo '>';
	echo set_value($frm["name"],$value);
	echo '</textarea>';
	echo form_error($frm["name"]);	
}

function my_form_age($frm){
//echo print_r($frm);
	echo '<input type="text" id="year" name="year" class="age" value="'.set_value("year").'"> Years &nbsp;&nbsp;&nbsp;';
	echo '<input type="text" id="month" name="month"  class="age" value="'.set_value("month").'"> Months&nbsp;&nbsp;&nbsp;';
	echo '<input type="text" id="day" name="day"  class="age" value="'.set_value("month").'"> Days &nbsp;&nbsp;&nbsp;';	
	echo form_error($frm["name"]);	
}
function my_form_dropdown($frm,$opt,$val,$fid=null){
	if (!empty($frm["can_edit"])){
		if ($val){
			if(!got_access($frm["can_edit"])){
				echo '<input  class="form-control input-sm"';
						echo ' type="text" ';
					echo 'id="'.$frm["id"].'" ';
					echo 'name="'.$frm["name"].'" ';
					echo 'value="'.set_value($frm["name"],$val).'" ';
					if (isset($frm["class"])){ 
						echo 'class="'.$frm["class"].'" ';
					}
					if (isset($frm["rules"])){		
						echo 'rules="'.$frm["rules"].'" ';
					}		
					echo ' readonly=true ';
				echo ' >';
				return;
			}	
		}	
	}// DONT have access to edit
	echo '<select  class="form-control input-sm" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'id="'.$frm["id"].'" ';	
		echo 'class="input" ';
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
		
	echo '>';
	echo '<option ></option>';
	foreach ($opt as $key => $value) {
		echo '<option ';
		echo 'value="'.$value.'"';
		if (set_value($frm["name"],$val) == $value){
		 echo ' selected ';
		}
		echo ' >';
		echo $value;
		echo '</option >';
	}
	echo '</select>';
	echo form_error($frm["name"]);	
}
function my_form_table_select($frm,$opt,$val,$fid=null){
	
	
	if (!empty($frm["can_edit"])){
		if ($fid>0){
			if(!got_access($frm["can_edit"])){
				echo '<input  class="form-control input-sm"';
						echo ' type="text" ';
					echo 'id="'.$frm["id"].'" ';
					echo 'name="'.$frm["name"].'" ';
					echo 'value="'.set_value($frm["name"],$val).'" ';
					if (isset($frm["class"])){ 
						echo 'class="'.$frm["class"].'" ';
					}
					if (isset($frm["rules"])){		
						echo 'rules="'.$frm["rules"].'" ';
					}		
					echo ' readonly=true ';
				echo ' >';
				return;
			}	
		}	
	}// DONT have access to edit
	
	echo '<select  class="form-control input-sm" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'id="'.$frm["id"].'" ';	
		echo 'class="input" ';
		if (isset($frm["style"])){
			echo ' '.$frm["style"].'  ';
		}
	echo '>';
		echo '<option ></option>';

	foreach ($opt as $key => $value) {
		
		echo '<option ';
		echo 'value="'.$value[$frm["option"]].'"';
		if (set_value($frm["name"],$val) == $value[$frm["option"]]){
		 echo ' selected ';
		}
//PP configuration		
		//OPD Preselection if PP config
		if ($frm["id"]=="Stock" && $frm["config"]=="PP"){
			if (set_value($frm["name"],'1') == $value[$frm["option"]]){
				 echo ' selected ';
			}
		}
		
		
		echo ' >';
		echo $value[$frm["name"]];
		echo '</option >';
	}
	echo '</select>';
	echo form_error($frm["name"]);	
}
function my_form_boolean($frm,$opt=array("1"=>"Yes","0"=>"No"),$val,$fid=null){
	echo '<select  class="form-control input-sm" ';
		echo 'name="'.$frm["name"].'" ';
		echo 'id="'.$frm["id"].'" ';	
		echo 'class="input" ';
		if (isset($frm["style"])){
			echo 'style="'.$frm["style"].'" ';
		}
	echo '>';
	echo '<option ></option>';
	foreach ($opt as $key => $value) {
		echo '<option ';
		echo 'value="'.$key.'"';
		if (set_value($frm["name"],$val) != ""){
			if (set_value($frm["name"],$val) == $key){
				echo ' selected ';
			}
		}
		echo ' >';
		echo $value;
		echo '</option >';
	}
	echo '</select>';
	echo form_error($frm["name"]);	
}
function my_form_id($frm,$val){
	echo '<input type="hidden" readonly ';
		echo 'id="'.$frm["OBJID"].'" ';
		echo 'name="'.$frm["OBJID"].'" ';
		echo 'value="'.set_value($frm["OBJID"],$val[$frm["OBJID"]]).'" ';
	echo '>';
}

function get_age($dob){
			$date1 = $dob;
			$date2 = date('Y/m/d');

			$diff = abs(strtotime($date2) - strtotime($date1));

			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			return array('years'=>$years,'months'=> $months,'days'=>$days);
}
 
?>

<script language="javascript">
function getCannedText(obj) {
    var remarks_text = String($(obj).val());
    var srh_text = "";
    if (remarks_text[String(remarks_text).length - 1] == " ") {
        if (remarks_text.indexOf("\\") >= 0) {
            srh_text = remarks_text.substr(remarks_text.indexOf("\\") + 1,
                remarks_text.indexOf(" "));
            loadCannedText(srh_text, obj);
        }
    }
}

function loadCannedText(srh, obj) {
    var ihtml = $.ajax({
        url : "<?php echo site_url("lookup/cannedtext/"); ?>"+srh,
        global : false,
        type : "POST",
        async : false
    }).responseText;
    if (ihtml.length > 1) {
        canned_text = ihtml.substr(0, ihtml.length)
        $(obj).val($(obj).val().replace('\\' + srh, String(canned_text)));
    }

}
</script>