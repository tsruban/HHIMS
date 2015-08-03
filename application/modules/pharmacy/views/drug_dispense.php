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
			<div class="panel-heading" ><b>
			<?php 
				echo $title; 
			?></b>
				<?php
				if (!empty($stock_info)){
					echo ''. $stock_info["name"].' stock in use';
				}
				?>
			</div>
		
			<div class="" style="margin-bottom:1px;padding-top:8px;">
				<?php 
					echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;">';
						echo '<tr>';
							echo '<td>';
								echo 'Complaint / Injuries : <b id="opd_complaint">'.$opd_visits_info["Complaint"].'</b>';
							echo '</td>';
							echo '<td>';
								echo 'Onset Date : <b>'.$opd_visits_info["OnSetDate"].'</b>';
							echo '</td>';
							echo '<td>';
								echo 'Visit type : <b>'.$opd_visits_info["visit_type_name"].'</b>';
							echo '</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>';
								if (isset($opd_presciption_info["Status"])){
									echo 'Status : <b>'.$opd_presciption_info["Status"].'</b>';
								}
							echo '</td>';						
							echo '<td>';
								if (isset($opd_visits_info["Doctor"])){
									echo 'Doctor : <b>'.$opd_visits_info["Doctor"].'</b>';
								}
							echo '</td>';
							echo '<td>';							
								if (isset($opd_presciption_info["PrescribeDate"])){
									echo 'Prescribe Date : <b>'.$opd_presciption_info["PrescribeDate"].'</b>';
									
								}
							echo '</td>';
						echo '</tr>';	
					echo '</table><br>';	
					//print_r($opd_presciption_info);
					if (isset($prescribe_items_list)){
						if ($opd_presciption_info["Status"] =="Pending"){
							echo '<form id="drug_form" method="POST" action="'.site_url("pharmacy/save_dispense").'" >';
						}
						echo '<input id="PRSID" name="PRSID" type="hidden" value="'.$opd_presciption_info["PRSID"].'" >';
						echo '<input id="drug_stock_id" name="drug_stock_id" type="hidden" value="'.(isset($stock_info["drug_stock_id"])?$stock_info["drug_stock_id"]:"").'" >';
						echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;">';
						echo '<tr style="background:#e2e2e2;"><th>#</th><th>Name</th><th>Formulation</th><th>Dose</th><th>Frequency</th><th>Period</th>';
						
						echo '<th>Quantity</th><th>Print</th>';

						echo '</tr>';
							for($i=0; $i < count($prescribe_items_list);++$i){
								echo '<tr>';
									echo '<td>';
										echo ($i+1);
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["drug_name"]. '-' .$prescribe_items_list[$i]["drug_dose"];
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["drug_formulation"];
									echo '</td>';									
									echo '<td>';
										echo $prescribe_items_list[$i]["Dosage"];
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["Frequency"];
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["HowLong"];
									echo '</td>';
									echo '<td>';
									if (($prescribe_items_list[$i]["Frequency"]) &&($prescribe_items_list[$i]["drug_formulation"] == "tabs")){
										$n = $this->config->item($prescribe_items_list[$i]["HowLong"]);
										$cnt = $this->config->item($prescribe_items_list[$i]["Frequency"]);
										$d_count = $n*$cnt;
									}
									else{
										$d_count = 1;
									}
									if ($opd_presciption_info["Status"] =="Pending"){
										echo '<input id="'.$prescribe_items_list[$i]["PRS_ITEM_ID"].'" name="'.$prescribe_items_list[$i]["PRS_ITEM_ID"].'" type="number" min=0 step=1 max=130 value="'.$d_count.'">';		
										echo '<input id="_'.$prescribe_items_list[$i]["PRS_ITEM_ID"].'" name="_'.$prescribe_items_list[$i]["PRS_ITEM_ID"].'" type="hidden" value="'.$prescribe_items_list[$i]["DRGID"].'">';		
									}
									else{
										echo $prescribe_items_list[$i]["Quantity"];
									}
									echo '</td>';

                                echo '<td><input type="checkbox" name="print[]" id="print" value='.$prescribe_items_list[$i]["PRS_ITEM_ID"].' /></td>';
								echo '</tr>';
							}
						echo '</table>';
							echo '<hr>';
							echo '<center>';
							if ($opd_presciption_info["Status"] =="Pending"){
								echo '<button type="submit" class="btn  btn-primary " >Dispense</button>&nbsp;&nbsp;';
							}
                            echo "<input onclick=\"printPrescription('" . site_url("report/pdf/outsidePrescription/print/") . "')\" value='Print' type='button' class='btn btn-default'/>&nbsp;&nbsp;";
							echo '<a  href="'.site_url("pharmacy/show_list/".$opd_presciption_info["Dept"]).'">Back to list</a>';
							echo '</center>';
							if ($opd_presciption_info["Status"] =="Pending"){
								echo '</form>';
							}
						
					}
				?>				
			</div>
		</div>	
	</div>
	<div class="col-md-2">

		<!-- ALLERGY-->
		<div class="panel  panel-danger"  style="padding:2px;margin-bottom:1px;" >
			<div class="panel-heading" ><b>Allergies</b></div>
			<?php
				//print_r($patient_allergy_list);
				if ((!isset($patient_allergy_list))||(empty($patient_allergy_list))){
					echo " - NO DATA - ";
				}
				else{
					echo '<table class="table table-condensed"  style="font-size:0.95em;margin-bottom:0px;">';
					for ($i=0;$i<count($patient_allergy_list); ++$i){
						echo '<tr >';
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
  
  </div>
	</div>
</div>
<script language="javascript">
var current_drug = {
	'wd_id':null,
	'name':null,
	'formulation':null,
	'frequency':null,
	'period':null
};
function load_group(){
	current_drug = {
		'wd_id':null,
		'name':null,
		'formulation':null,
		'frequency':null,
		'period':null
	};
	$("#choose_method").val("by_group");
	$("#btn_by_group").removeClass("btn-primary").addClass("btn-success");
	$("#btn_by_name").removeClass("btn-success");
	$("#btn_by_favour").removeClass("btn-success");
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
		'period':null
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
		'period':null
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
				$("#blk_drug_name").append('<select class="input" id="blk_drug_name_list" onchange=select_formulation(this.value) size=15 style="height:330px;width:550px;"></select>');
			}
			else{
				$("#blk_drug_name").append('<select class="input" id="blk_drug_name_list" onchange=select_formulation(this.value) size=15 style="height:330px;width:420px;"></select>');
			}
			$("#blk_drug_name_list").html('');
			try{
				for (var i=0; i<data.length; i++){
					var option = '<option value="'+data[i]["wd_id"]+'"  ';
					var drug_level = parseInt("+<?php echo $this->config->item('drug_alert_count'); ?>");
					
					if (data[i]["who_drug_count"] <= drug_level){
						option += ' style="color:red" ' ;
						option += 'title="'+data[i]["name"]+' (Not in Stock)"';
						option += '>'+data[i]["name"]+'</option>';
					}else{
						option += ' style="color:blue" ';
						option += 'title="'+data[i]["name"]+' ('+data[i]["who_drug_count"]+ ')"';
						option += '>'+data[i]["name"]+' ('+data[i]["who_drug_count"]+ ')</option>';
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
	enable_button();
}

function select_formulation(wd_id){

	current_drug.formulation = $("#blk_drug_formulation_list option:selected").text();
	current_drug.wd_id = wd_id;
	current_drug.name = $("#blk_drug_name_list option:selected").text();
	current_drug.frequency = null;
	current_drug.period = null;	
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_frequency",
		type: "post"
	});
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
		//}
	});
	enable_button();
}

function select_fq(fq_id){
	current_drug.frequency = $("#blk_drug_fq_list option:selected").text();
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
	$("#add_cont").html('<button type="button" class="btn btn-primary btn-lg btn-block" onclick=$("#drug_form").submit(); >'+prescribe_text+'</button>');
	update_form();

}
function update_form(){
	$("#Frequency").val(current_drug.frequency);
	$("#HowLong").val(current_drug.period);
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
	$("#blk_2_content").html('');
	load_drug_name("");
}

function load_favour(){
	$("#choose_method").val("by_favour");
	$("#btn_by_favour").removeClass("btn-primary").addClass("btn-success");
	$("#btn_by_name").removeClass("btn-success");
	$("#btn_by_group").removeClass("btn-success");
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

function load_favour_drug_item(favour_id){
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/user/get_my_favour_drug_list/"+favour_id,
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
						option += '>'+data[i]["name"]+'</option>';
					}else{
						option += ' style="color:blue" ';
						option += 'title="'+data[i]["name"]+' ('+data[i]["who_drug_count"]+ ')"';
						option += '>'+data[i]["name"]+' ('+data[i]["who_drug_count"]+ ')</option>';
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
	if ($("#choose_method").val() == "by_group"){
		load_group();
	}
	else if ($("#choose_method").val() == "by_name"){
		load_name();
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

function printPrescription(url){
    var data='?';
    $.each( $("#print:checked" ), function( key, value ) {
        data+='print[]='+$(this).val()+'&';
    });
    var pId=<?php echo $opd_visits_info['PID'] ?>;
    data+='pid='+pId;
    var params = "menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700";
    window.open(url + data, "lookUpW",params);
}

</script>