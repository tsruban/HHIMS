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
	
	<div class="col-md-12 " >
		<?php
			if (isset($PID)){
				echo Modules::run('patient/banner',$PID);
			}
		?>
		<div class="panel panel-default  "  style="padding:2px;margin-bottom:1px;" >
			<div class="panel-heading" ><b>In-Patient drug order form</b>
			</div>
			<div class="" style="margin-bottom:1px;padding-top:8px;">
				<?php 
					echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;">';
						echo '<tr>';
							echo '<td>';
								echo 'Complaint / Injuries : <b id="opd_complaint">'.$admission_info["Complaint"].'</b>';
							echo '</td>';
							echo '<td>';
								echo 'Onset Date : <b>'.$admission_info["OnSetDate"].'</b>';
							echo '</td>';
							echo '<td>';
								echo 'Admission Date : <b>'.$admission_info["AdmissionDate"].'</b>';
							echo '</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>';
								if (isset($admission_info["BHT"])){
									echo 'BHT : <b>'.$admission_info["BHT"].'</b>';
								}
							echo '</td>';						
							echo '<td>';
								if (isset($admission_info["Doctor"])){
									echo 'Doctor : <b>'.$admission_info["Doctor"].'</b>';
								}
							echo '</td>';
							echo '<td>';							
								//print_r($stock_list);
								//echo 'Which stock to use? : ';
								
							echo '</td>';
						echo '</tr>';	
					echo '</table><br>';	
					//print_r($opd_presciption_info);
					if (isset($prescribe_items_list)){
						echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;" border=1>';
						echo '<tr style="background:#e2e2e2;"><th>#</th><th width=150 nowrap>Date</th><th>Name</th><th>Dose</th><th>Frequency</th><th width=102>Type</th>';
						
						echo '<th>Status</th>';

						echo '</tr>';
							for($i=0; $i < count($prescribe_items_list);++$i){
							//print_r($prescribe_items_list[$i]);
								echo '<tr ';
								if ($prescribe_items_list[$i]["Status"] == "Discontinue"){
									echo ' style="text-decoration:line-through" ';
								}
								echo '>';
								
									echo '<td>';
										echo ($i+1);
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["CreateDate"];
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["drug_name"];
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["Dosage"];
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["Frequency"];
									echo '</td>';
									echo '<td>';
										if( $prescribe_items_list[$i]["type"] == "Once only"){
											echo '<span class="label label-danger">'.$prescribe_items_list[$i]["type"].'</span>';
										}
										else if( $prescribe_items_list[$i]["type"] == "Regular"){
											echo '<span class="label label-success">'.$prescribe_items_list[$i]["type"].'</span>';
										}
										else{
											echo '<span class="label label-warning">'.$prescribe_items_list[$i]["type"].'</span>';
										}
									echo '</td>';
									echo '<td width=102px>';
									//if ($admission_presciption_info["Status"] == "Draft") {
										//echo '<button type="button" class="btn btn-default btn-xs" title=" Remove this item" onclick=delete_record("'.$prescribe_items_list[$i]["prescribe_items_id"].'"); >
												//<span class="glyphicon glyphicon-remove-circle"></span>
												//</button>';
										echo 	'<select style="width:100px;" onchange=update_status(this.value,"'.$prescribe_items_list[$i]["prescribe_items_id"].'"); >';
											echo '<option></option>';
											echo 	'<option value="Discontinue" ';
												if ($prescribe_items_list[$i]["Status"] == "Discontinue"){
													echo ' selected ';
												}
											echo 	'>';
												echo 	'Discontinue';
											echo 	'</option>';
											echo 	'<option value="Continue" ';
												if ($prescribe_items_list[$i]["Status"] == "Continue"){
													echo ' selected ';
												}
											echo 	'>';
												echo 	'Continue';
											echo 	'</option>';
										echo 	'</select>';
										; ;
									//}			
									echo '</td>';
								echo '</tr>';
							}
						echo '</table>';
						
							//echo ' <a href="'.site_url("".$admission_info["ADMID"]).'" type="button" class="btn  pull-left btn-warning btn-xs"  >Print this</a>';
						
						if (count($prescribe_items_list)>0){
							//echo '<button type="button" class="btn  pull-right btn-danger btn-xs" onclick=discard(); >Discard</button>';
							//echo '<button type="button" class="btn pull-right btn-success btn-xs" onclick=send_to_pharmacy("'.$admission_presciption_info["admission_prescription_id"].'","'.$admission_info["ADMID"].'"); >Send to pharmacy</button>';
						}
					}
					echo '<center><a href="'.site_url("admission/view/".$admission_info["ADMID"]).'" type="button" class="btn  btn-default btn"  >Back to admission</a></center>';
					
					if ($admission_info["OutCome"]) {
							echo '</div>';
							exit;
					}
				?>				
			</div><br><br>
			<table class="table table-condensed" border=0 style="background:#f4f4f4">
				<tr id="blk_choose">
					<td width=150px>
						<b>How to Choose</b>
						<button type="button" id="btn_by_group" class="btn btn-default btn-sm">By group</button>
						<button type="button" id="btn_by_name"  class="btn btn-default btn-sm">By name</button>
						
						
						
						<?php
						echo '<select onchange=$("#drug_stock_id").val(this.value) id="stock_id" name="stock_id" class=" pull-right" style="width:150px;">';
									echo '<option value="">...Stock?...</option>';
									foreach($stock_list as $key=>$value) {
										echo '<option value="'.$value["drug_stock_id"].'">'.$value["name"].'</option>';
									}
								echo '</select>';
						/*
						<button type="button" id="btn_by_favour" class="btn btn-default btn-sm">
							<span class="glyphicon glyphicon-heart"></span>&nbsp;My favourites
							<?php
								if(isset($my_favour)){
									echo '<span class="badge">'.$my_favour.'</span>';
								}
							?>
						</button>
							if (isset($prescribe_items_list)&&(count($prescribe_items_list)>0)){
								echo '<button  ';
								echo 'onclick=add_to_favour("'.$admission_presciption_info["admission_prescription_id"].'"); ';
								echo ' type="button" id="btn_add_favour" class="btn btn-primary  btn-sm pull-right"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add above list to My favourites</button>';
							}
						*/	
						?>
					</td>
				<tr>
				<tr id="blk_2_tr">
					<td id="blk_2">
						<table >
						<tr>
						<td>
							<table class="" width=10% border=0>
								<tr id="blk_2_content">
								<tr>
							</table>
						</td>
						<td style="vertical-align:middle">
							<div id="add_cont" class=""></div>
						</td>
						</tr>
						</table>
						<form id="drug_form" method="POST" action="<?php echo site_url("admission/save_prescription"); ?>" >
							<input type="hidden" name="PRSID" id="PRSID" value="<?php echo isset($admission_presciption_info["admission_prescription_id"])?$admission_presciption_info["admission_prescription_id"]:null; ?>">
							<input type="hidden" name="CONTINUE" id="CONTINUE" value="<?php echo isset($_GET["CONTINUE"])?$_GET["CONTINUE"]:null; ?>">
							<input type="hidden" name="ADMID" id="ADMID" value="<?php echo $admission_info["ADMID"]; ?>">
							<input type="hidden" name="PID" id="PID" value="<?php echo $PID; ?>">
							<input type="hidden" name="wd_id"  id="wd_id" value="">
							<input type="hidden" name="Frequency" id="Frequency" value="">
							<input type="hidden" name="Dose" id="Dose" value="">
							<input type="hidden" name="HowLong" id="HowLong" value="">
							<input type="hidden" name="d_type" id="d_type" value="">
							<input type="hidden" name="drug_stock_id" id="drug_stock_id" value="">
							<?php
								
								echo '<input type="hidden" name="choose_method" id="choose_method" value="';
								if (isset($user_info["last_prescription_cmd"])){
									echo $user_info["last_prescription_cmd"];
								}
								else{
									echo "by_group";
								}
								echo '" >';
							?>	
						</form>
					</td>
				<tr>
			</table>
		</div>	
	</div>

	</div>
</div>
<script language="javascript">
	current_drug = {
		'wd_id':null,
		'name':null,
		'formulation':null,
		'frequency':null,
		'period':null,
		'd_type':null
	};
function update_status(sts,id){
var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/admission/update_status/"+sts+"/"+id,
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		if (response >0){
			location.reload();
		}
	});
}
function load_group(){
	current_drug = {
		'wd_id':null,
		'name':null,
		'formulation':null,
		'frequency':null,
		'period':null,
		'd_type':null
	};
	$("#choose_method").val("by_group");
	$("#btn_by_group").removeClass("btn-primary").addClass("btn-success");
	$("#btn_by_name").removeClass("btn-success");
	$("#btn_by_favour").removeClass("btn-success");
	$("#btn_by_previous").removeClass("btn-success");
	$("#add_cont").html('');
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_drugs_groups/",
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		if (data.length>0){
			$("#blk_2_content").html('<td id="blk_group" width=1%></td>');
			$("#blk_group").append('<b>Group</b><br>');
			$("#blk_group").append('<select class="input" id="blk_group_list" onchange=load_sub_group(this.value) size=15 style="height:330px;width:200px;"></select>');
			try{
				for (var i=0; i<data.length; i++){
					$("#blk_group_list").append('<option value="'+data[i]["wd_id"]+'"  title="'+data[i]["group"]+'">'+data[i]["group"]+'</option>');
				}
			}catch(e){
			}

		}
	});
}
function load_sub_group(id){
	current_drug = {
		'wd_id':null,
		'name':null,
		'formulation':null,
		'frequency':null,
		'period':null,
		'd_type':null
	};

	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_drugs_sub_groups/"+id,
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		//if (data.length>0){
			if (!$("#blk_sub_group").get(0) ){
				$("#blk_2_content").append('<td id="blk_sub_group" width=1%></td>');
			}
			$("#blk_sub_group").html('');
			$("#blk_drug_name").html('');
			$("#blk_drug_formulation_list").html('');
			$("#add_cont").html('');
			$("#blk_sub_group").append('<b>Sub group</b><br>');
			$("#blk_sub_group").append('<select class="input" id="blk_sub_group_list" onchange=load_drug_name(this.value) size=15 style="height:330px;width:180px;"></select>');
			$("#blk_sub_group_list").html('');
			try{
				for (var i=0; i<data.length; i++){
					$("#blk_sub_group_list").append('<option value="'+data[i]["wd_id"]+'"  title="'+data[i]["sub_group"]+'">'+data[i]["sub_group"]+'</option>');
				}
			}catch(e){
			}
		//}
	});
}

function load_drug_name(id){
	current_drug = {
		'wd_id':null,
		'name':null,
		'formulation':null,
		'frequency':null,
		'period':null,
		'd_type':null
	};
	var stock_id = $("#drug_stock_id").val();
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_drug_name",
		type: "post",
		data:{"id":id,"drug_stock_id":stock_id}
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		//if (data.length>0){
			if (!$("#blk_drug_name").get(0) ){
				$("#blk_2_content").append('<td id="blk_drug_name" width=1%></td>');
			}
			$("#blk_drug_name").html('');
			$("#blk_drug_formulation_list").html('');
			$("#blk_drug_name").append('<b>Name</b><br>');
			$("#add_cont").html('');
			if ($("#choose_method").val() =="by_name"){
				$("#blk_drug_name").append('<select class="input" id="blk_drug_name_list" onchange=load_type(this.value) size=15 style="height:330px;width:450px;"></select>');
			}
			else{
				$("#blk_drug_name").append('<select class="input" id="blk_drug_name_list" onchange=load_type(this.value) size=15 style="height:330px;width:320px;"></select>');
			}
			$("#blk_drug_name_list").html('');
			try{
				for (var i=0; i<data.length; i++){
					var option = '<option value="'+data[i]["wd_id"]+'"  ';
					var drug_level = parseInt("+<?php echo $this->config->item('drug_alert_count'); ?>");
					
					if (data[i]["who_drug_count"] <= drug_level){
						option += ' style="color:red" ' ;
						option += 'title="'+data[i]["name"]+' '+data[i]["formulation"]+' (Not in Stock)"';
						option += '>'+data[i]["name"]+'-'+data[i]["formulation"]+'-'+data[i]["dose"]+' </option>';
					}else{
						option += ' style="color:blue" ';
						option += 'title="'+data[i]["name"]+' ('+data[i]["who_drug_count"]+ ')"';
						option += '>'+data[i]["name"]+'-'+data[i]["formulation"]+'-'+data[i]["dose"];
						if (data[i]["who_drug_count"]>0){
							option += ' ('+data[i]["who_drug_count"]+ ')';
						}
						option += '</option>';
					}
					//'/'+data[i]["who_drug_count"]+'/'+drug_level+
					//option += '>'+data[i]["name"]+' ('+data[i]["who_drug_count"]+ ')</option>';
					$("#blk_drug_name_list").append(option);
				}
			}catch(e){
			}
		//}
	});
}

function load_formulation(id){
	current_drug.wd_id = id;
	current_drug.name = $("#blk_drug_name_list option:selected").text();
	current_drug.formulation = null;
	current_drug.frequency = null;
	current_drug.dose = null;
	current_drug.period = null;
	
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_formulation/"+id,
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		//if (data.length>0){
			if (!$("#blk_drug_formulation").get(0) ){
				$("#blk_2_content").append('<td id="blk_drug_formulation" width=1%></td>');
			}
			$("#blk_drug_formulation").html('');
			$("#blk_drug_formulation").append('<b>Formulation</b><br>');
			$("#blk_drug_formulation").append('<select class="input" id="blk_drug_formulation_list" onchange=select_formulation(this.value) size=15 style="height:330px;width:150px;"></select>');
			$("#blk_drug_formulation_list").html('');
			//$("#add_cont").html('');
			try{
				for (var i=0; i<data.length; i++){
					$("#blk_drug_formulation_list").append('<option value="'+data[i]["wd_id"]+'" title="'+data[i]["formulation"]+'">'+data[i]["formulation"]+'</option>');
				}
			}catch(e){
			}
		//}
		
	});
	//enable_button();
}

function select_formulation(typ){

	current_drug.formulation = $("#blk_drug_formulation_list option:selected").text();
	current_drug.wd_id = wd_id;
	current_drug.name = $("#blk_drug_name_list option:selected").text();
	current_drug.dose = null;
	current_drug.frequency = null;
	current_drug.period = null;	
	current_drug.d_type = typ;	
	
	if (typ =="Once only"){
		load_dose();
		return;
	}
	else if(typ =="Regular"){
		load_dose();
	}
	else{ //as-needed
		load_dose();
		return;
	}
	
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_frequency",
		type: "post"
	});

	//load_type();
	//load_dose();
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		//if (data.length>0){
			if (!$("#blk_drug_fq").get(0) ){
				$("#blk_2_content").append('<td id="blk_drug_fq" width=1%></td>');
			}
			$("#blk_drug_fq").html('');
			//$("#add_cont").html('');
			$("#blk_drug_fq").append('<b>Frequency</b><br>');
			$("#blk_drug_fq").append('<select class="input" id="blk_drug_fq_list" onchange=select_fq(this.value) size=15 style="height:330px;width:100px;"></select>');
			$("#blk_drug_fq_list").html('');
			try{
				for (var i=0; i<data.length; i++){
					$("#blk_drug_fq_list").append('<option value="'+data[i]["DFQYID"]+'" title="'+data[i]["Frequency"]+'">'+data[i]["Frequency"]+'</option>');
				}
			}catch(e){
			}
			
			//load_period();
		//}
	});
	
	enable_button();
}
function load_type(id){
	current_drug.wd_id = id;
	current_drug.name = $("#blk_drug_name_list option:selected").text();
	current_drug.formulation = null;
	current_drug.frequency = null;
	current_drug.dose = null;
	current_drug.period = null;	
	current_drug.d_type= null;	
	
	var d_type = new Array('Once only','Regular','As-Needed');
	if (!$("#blk_drug_type").get(0) ){
		$("#blk_2_content").append('<td id="blk_drug_type" width=1%></td>');
		
	}
	$("#blk_drug_type").html('');
	$("#blk_drug_type").append('<b>Type</b><br>');
	$("#blk_drug_type").append('<select class="input" id="blk_drug_type_list" onchange=select_formulation(this.value) size=15 style="height:330px;width:100px;"></select>');
	$("#blk_drug_period_list").html('');
	$("#add_cont").html('');
	try{
		for (var i=0; i<d_type.length; i++){
			$("#blk_drug_type_list").append('<option value="'+d_type[i]+'" title="'+d_type[i]+'">'+d_type[i]+'</option>');
		}
	}catch(e){
	}	
	enable_button();
}
function load_dose(){
	current_drug.dose = null;	
	var period = new Array('1','1 1/2','2/3','1/3','1/4','2','3','4');
	var period_val = new Array('1','1.5','0.6','0.3','0.25','2','3','4');
	if (!$("#blk_drug_dose").get(0) ){
		$("#blk_2_content").append('<td id="blk_drug_dose" width=1%></td>');
		
	}
	$("#blk_drug_dose").html('');
	$("#blk_drug_dose").append('<b>Dose</b><br>');
	$("#blk_drug_dose").append('<select class="input" id="blk_drug_dose_list" onchange=select_dose(this.value) size=15 style="height:330px;width:80px;"></select>');
	$("#blk_drug_period_list").html('');
	$("#add_cont").html('');
	try{
		for (var i=0; i<period.length; i++){
			$("#blk_drug_dose_list").append('<option value="'+period[i]+'" title="'+period[i]+'">'+period[i]+'</option>');
		}
	}catch(e){
	}	
	enable_button();
}
function load_period(){
	current_drug.period = null;	
	var period = new Array('For 1 day','For 2 days','For 3 days','For 4 days','For 5 days','For 1 week','For 2 weeks','For 3 weeks','For 1 month');
	if (!$("#blk_drug_period").get(0) ){
		$("#blk_2_content").append('<td id="blk_drug_period" width=1%></td>');
	}
	$("#blk_drug_period").html('');
	$("#blk_drug_period").append('<b>Period</b><br>');
	$("#blk_drug_period").append('<select class="input" id="blk_drug_period_list" onchange=select_period(this.value) size=15 style="height:330px;width:100px;"></select>');
	$("#blk_drug_period_list").html('');
	$("#add_cont").html('');
	try{
		for (var i=0; i<period.length; i++){
			$("#blk_drug_period_list").append('<option value="'+period[i]+'" title="'+period[i]+'">'+period[i]+'</option>');
		}
	}catch(e){
	}	
	enable_button();
}

function select_fq(fq_id){
	current_drug.frequency = $("#blk_drug_fq_list option:selected").text();
	$("#Frequency").val(current_drug.frequency);
}

function select_dose(dose_id){
	current_drug.dose = $("#blk_drug_dose  option:selected").val();
	$("#Dose").val(current_drug.dose);
}

function enable_button(){
	var prescribe_text = 'ADD: ' ;
	prescribe_text += current_drug.name ;
	if (current_drug.formulation){
		prescribe_text += ' / '+current_drug.formulation;
	}
	
	if(current_drug.frequency){
		prescribe_text += ' / '+current_drug.frequency ;
	}
	if(current_drug.period){
		prescribe_text += ' / '+current_drug.period+' ? ';
	}
	if ($("#add_btn").length ==0){
		//$("#blk_2_content").append('<button type="button" class="btn btn-primary btn-lg btn-block" onclick=$("#drug_form").submit(); id="add_btn" >+Add</button>')
	}
	$("#add_cont").html('<button type="button" class="btn btn-primary btn-lg btn-block" onclick=$("#drug_form").submit(); >+ADD</button>');
	update_form();
}

function update_form(){
	$("#Frequency").val(current_drug.frequency);
	$("#HowLong").val(current_drug.period);
	$("#d_type").val(current_drug.d_type);
	$("#Dose").val(current_drug.dose);
	$("#wd_id").val($("#blk_drug_name_list").val());
}

function select_period(period){
	current_drug.period = $("#blk_drug_period_list option:selected").text();
	enable_button();
}

function load_name(){
	$("#choose_method").val("by_name");
	$("#btn_by_name").removeClass("btn-primary").addClass("btn-success");
	$("#btn_by_group").removeClass("btn-success");
	$("#btn_by_favour").removeClass("btn-success");
	$("#btn_by_previous").removeClass("btn-success");
	$("#blk_2_content").html('');
	load_drug_name("");
}

function load_favour(){
	$("#choose_method").val("by_favour");
	$("#btn_by_favour").removeClass("btn-primary").addClass("btn-success");
	$("#btn_by_name").removeClass("btn-success");
	$("#btn_by_group").removeClass("btn-success");
	$("#btn_by_previous").removeClass("btn-success");
	$("#blk_2_content").html('');
	current_drug = {
		'wd_id':null,
		'name':null,
		'formulation':null,
		'frequency':null,
		'period':null
	};
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/user/get_my_favour/",
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		if (data.length>0){
			$("#blk_2_content").html('<td id="blk_group" width=1%></td>');
			$("#blk_group").append('<b>My favourites</b><br>');
			$("#blk_group").append('<select class="input" id="blk_group_list" onchange=load_favour_drug_item(this.value) size=15 style="height:330px;width:200px;"></select>');
			try{
				for (var i=0; i<data.length; i++){

					$("#blk_group_list").append('<option value="'+data[i]["user_favour_drug_id"]+'"  title="'+data[i]["name"]+'">'+data[i]["name"]+'</option>');
				}
			}catch(e){
			}

		}
	});	
}

function load_previous(){
	$("#choose_method").val("by_previous");
	$("#btn_by_previous").removeClass("btn-primary").addClass("btn-success");
	$("#btn_by_name").removeClass("btn-success");
	$("#btn_by_group").removeClass("btn-success");
	$("#btn_by_favour").removeClass("btn-success");
	$("#blk_2_content").html('');
	current_drug = {
		'wd_id':null,
		'name':null,
		'formulation':null,
		'frequency':null,
		'period':null
	};
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/opd/get_previous_prescription/"+$("#OPDID").val()+"/"+$("#drug_stock_id").val(),
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		if (data.length>0){
			$("#blk_2_content").html('<td id="blk_group" width=1%></td>');
			$("#blk_group").append('<b>Previous prescription</b><br>');
			$("#blk_group").append('<select class="input" id="blk_drug_name_list" onchange=select_formulation(this.value) size=15 style="height:330px;width:550px;"></select>');
			$("#blk_drug_name_list").html('');
			try{
				for (var i=0; i<data.length; i++){
					var option = '<option value="'+data[i]["wd_id"]+'" ';
					var drug_level = parseInt("+<?php echo $this->config->item('drug_alert_count'); ?>");
					
					if (data[i]["who_drug_count"] <= drug_level){
						option += ' style="color:red" ' ;
						option += 'title="'+data[i]["name"]+' (Not in Stock)"';
						option += '>'+data[i]["name"]+'-'+data[i]["formulation"]+'-'+data[i]["dose"]+'</option>';
					}else{
						option += ' style="color:blue" ';
						option += 'title="'+data[i]["name"]+' ('+data[i]["who_drug_count"]+ ')"';
						option += '>'+data[i]["name"]+'-'+data[i]["formulation"]+'-'+data[i]["dose"]+' ('+data[i]["who_drug_count"]+ ')</option>';
					}
					//'/'+data[i]["who_drug_count"]+'/'+drug_level+
					//option += '>'+data[i]["name"]+'</option>';
					$("#blk_drug_name_list").append(option);				
					//$("#blk_drug_name_list").append('<option value="'+data[i]["who_drug_id"]+'"  title="'+data[i]["name"]+'">'+data[i]["name"]+'</option>');
				}
			}catch(e){
			}

		}
	});	
}


function load_favour_drug_item(favour_id){
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/user/get_my_favour_drug_list/"+favour_id+"/"+$("#drug_stock_id").val(),
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		if (data.length>0){
			if (!$("#blk_sub_group").get(0) ){
				$("#blk_2_content").append('<td id="blk_sub_group" width=1%></td>');
			}
			$("#blk_sub_group").html('<b>Drug List</b><br>');
			$("#blk_sub_group").append('<select class="input" id="blk_drug_name_list" onchange=select_formulation(this.value) size=15 style="height:330px;width:550px;"></select>');
			$("#blk_drug_name_list").html('');
			try{
				for (var i=0; i<data.length; i++){
					var option = '<option value="'+data[i]["wd_id"]+'" ';
					var drug_level = parseInt("+<?php echo $this->config->item('drug_alert_count'); ?>");
					
					if (data[i]["who_drug_count"] <= drug_level){
						option += ' style="color:red" ' ;
						option += 'title="'+data[i]["name"]+' (Not in Stock)"';
						option += '>'+data[i]["name"]+'-'+data[i]["formulation"]+'-'+data[i]["dose"]+'</option>';
					}else{
						option += ' style="color:blue" ';
						option += 'title="'+data[i]["name"]+' ('+data[i]["who_drug_count"]+ ')"';
						option += '>'+data[i]["name"]+'-'+data[i]["formulation"]+'-'+data[i]["dose"]+' ('+data[i]["who_drug_count"]+ ')</option>';
					}
					//'/'+data[i]["who_drug_count"]+'/'+drug_level+
					//option += '>'+data[i]["name"]+'</option>';
					$("#blk_drug_name_list").append(option);				
					//$("#blk_drug_name_list").append('<option value="'+data[i]["who_drug_id"]+'"  title="'+data[i]["name"]+'">'+data[i]["name"]+'</option>');
				}
			}catch(e){
			}
		}
	})	
		
}

function add_to_favour(id){
	if (id=="") return;
	var name = prompt("Name of the list?",$("#opd_complaint").html());
	if ($.trim(name) == ""){
		alert("List name invalid");
		return;
	}
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/opd/prescription_add_favour/"+id,
		type: "post",
		data:{"name":name,"PRSID":id}
	});
	request.done(function (response, textStatus, jqXHR){
		if (response==1){
			location.reload();
		}
	});
}
function init(){
	$("#btn_by_group").click(function(){load_group();});
	$("#btn_by_name").click(function(){load_name();});
	$("#btn_by_favour").click(function(){load_favour();});
	$("#btn_by_previous").click(function(){load_previous();});
	if ($("#choose_method").val() == "by_group"){
		load_group();
	}
	else if ($("#choose_method").val() == "by_name"){
		load_name();
	}
	else if ($("#choose_method").val() == "by_previous"){
		load_previous();
	}
	else{
		load_favour();
	}

}
$(function(){
	init();
	
});

function delete_record(id){
	if (id=="") return;
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/opd/prescription_item_delete/"+id,
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		location.reload();
	});
}

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