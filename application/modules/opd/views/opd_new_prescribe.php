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
			<div class="panel-heading" ><b>OPD Prescription</b>
				<?php
				if (!empty($stock_info)){
					echo 'will use '. $stock_info["name"].' stock';
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
								echo 'Visit type : <b>'.$opd_visits_info["VisitType"].'</b>';
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
						echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;">';
						echo '<tr style="background:#e2e2e2;"><th>#</th><th>Name</th><th>Dose</th><th>Frequency</th><th>Period</th>';
						
						echo '<th>Option</th>';
						echo '<th>Print</th>';

						echo '</tr>';
							for($i=0; $i < count($prescribe_items_list);++$i){
							//print_r($prescribe_items_list[$i]);
								echo '<tr>';
									echo '<td>';
										echo ($i+1);
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["drug_name"];
										echo '-';
										echo $prescribe_items_list[$i]["formulation"];
										echo '-';
										echo $prescribe_items_list[$i]["dose"];
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
									if ($opd_presciption_info["Status"] == "Draft") {
										echo '<button type="button" class="btn btn-default btn-xs" title=" Remove this item" onclick=delete_record("'.$prescribe_items_list[$i]["PRS_ITEM_ID"].'"); >
												<span class="glyphicon glyphicon-remove-circle"></span>
												</button>';
									}			
									echo '</td>';
                                    echo '<td><input type="checkbox" name="print[]" id="print" value='.$prescribe_items_list[$i]["PRS_ITEM_ID"].' /></td>';

								echo '</tr>';
							}
						echo '</table>';
						
						echo '<a href="'.site_url("opd/view/".$opd_visits_info["OPDID"]).'" type="button" class="btn  pull-left btn-warning btn-xs"  >Back to visit</a>';
//						echo " <a href=\"#\" onclick=\"openWindow('" . site_url("report/pdf/opdPrescription/print/$prisid") . "')\" type=\"button\" class=\"btn  pull-left btn-warning btn-xs\"  >Print this</a>";
                        echo "<a href=\"#\" onclick=\"printPrescription('" . site_url("report/pdf/outsidePrescription/print/") . "')\"  type='button' class=\"btn  pull-left btn-warning btn-xs\"  >Print</a>";
						echo '<br><br>';
                            echo "<script language=\"javascript\">\n";
                            echo "function printPrescription(url){\n";
                            echo "    var data='?';\n";
                            echo "    $.each( $(\"#print:checked\" ), function( key, value ) {\n";
                            echo "        data+='print[]='+$(this).val()+'&';\n";
                            echo "    });\n";
                            echo "    var pId=$opd_visits_info[PID];\n";
                            echo "    data+='pid='+pId;\n";
                            echo "    var params = \"menubar=no,location=no,resizable=yes,scrollbars=yes,status=no,width=750,height=700\";\n";
                            echo "    window.open(url + data, \"lookUpW\",params);\n";
                            echo "}\n";
                            echo "</script>\n";
						if (($opd_presciption_info["Status"] == "Dispensed")||($opd_presciption_info["Status"] == "Pending")) {
							echo '</div><br><br>';
							exit;
						}
						if (count($prescribe_items_list)>0){
							echo '<button type="button" class="btn  pull-right btn-danger btn-xs" onclick=discard(); >Discard</button>';
							echo '<button type="button" class="btn pull-right btn-success btn-xs" onclick=send_to_pharmacy("'.$opd_presciption_info["PRSID"].'","'.$opd_visits_info["OPDID"].'"); >Send to pharmacy</button>';
							
						}
						
					}
				?>				
			</div><br><br>
			<table class="table table-condensed" border=0 style="background:#f4f4f4">
				<tr id="blk_choose">
					<td width=150px>
						<b>How to Choose</b>
						<button type="button" id="btn_by_group" class="btn btn-default btn-sm">By group</button>
						<button type="button" id="btn_by_name"  class="btn btn-default btn-sm">By name</button>
						<button type="button" id="btn_by_previous"  class="btn btn-default btn-sm">Previous prescriptions</button>
						<button type="button" id="btn_by_favour" class="btn btn-default btn-sm">
							<span class="glyphicon glyphicon-heart"></span>&nbsp;My favourites
							<?php
								if(isset($my_favour)){
									echo '<span class="badge">'.$my_favour.'</span>';
								}
							?>
						</button>
						
						<?php
							if (isset($prescribe_items_list)&&(count($prescribe_items_list)>0)){
								echo '<button  ';
								echo 'onclick=add_to_favour("'.$opd_presciption_info["PRSID"].'"); ';
								echo ' type="button" id="btn_add_favour" class="btn btn-primary  btn-sm pull-right"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add above list to My favourites</button>';
							}
						?>
					</td>
				</tr>
				<tr id="blk_2_tr">
					<td id="blk_2">
						<table >
						<tr>
						<td>
							<table class="" width=10% border=0>
								<tr id="blk_2_content">
								</tr>
							</table>
						</td>
						<td style="vertical-align:middle">
							<div id="add_cont" class=""></div>
						</td>
						</tr>
						</table>
						<form id="drug_form" method="POST" action="<?php echo site_url("opd/save_prescription"); ?>" >
							<input type="hidden" name="PRSID" id="PRSID" value="<?php echo isset($opd_presciption_info["PRSID"])?$opd_presciption_info["PRSID"]:null; ?>">
							<input type="hidden" name="CONTINUE" id="CONTINUE" value="<?php echo isset($_GET["CONTINUE"])?$_GET["CONTINUE"]:null; ?>">
							<input type="hidden" name="OPDID" id="OPDID" value="<?php echo $opd_visits_info["OPDID"]; ?>">
							<input type="hidden" name="PID" id="PID" value="<?php echo $PID; ?>">
							<input type="hidden" name="wd_id"  id="wd_id" value="">
							<input type="hidden" name="Frequency" id="Frequency" value="">
							<input type="hidden" name="Dose" id="Dose" value="">
							<input type="hidden" name="HowLong" id="HowLong" value="">
							<input type="hidden" name="drug_stock_id" id="drug_stock_id" value="<?php echo isset($stock_info["drug_stock_id"])?$stock_info["drug_stock_id"]:null ?>">
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
				</tr>
			</table>
		</div>	
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
var drug_list= new Array();

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
		'dose':null,
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
		drug_list = data;
		//if (data.length>0){
			if (!$("#blk_drug_name").get(0) ){
				$("#blk_2_content").append('<td id="blk_drug_name" width=1%></td>');
			}
			$("#blk_drug_name").html('');
			$("#blk_drug_formulation_list").html('');
			$("#blk_drug_name").append('<b>Name</b><br>');
			$("#add_cont").html('');
			if ($("#choose_method").val() =="by_name"){
				$("#blk_drug_name").append('<select class="input" id="blk_drug_name_list" onchange=select_formulation(this.value) size=15 style="height:330px;width:450px;"></select>');
			}
			else{
				$("#blk_drug_name").append('<select class="input" id="blk_drug_name_list" onchange=select_formulation(this.value) size=15 style="height:330px;width:320px;"></select>');
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
						option += '>'+data[i]["name"]+'-'+data[i]["formulation"]+'-'+data[i]["dose"]+' ('+data[i]["who_drug_count"]+ ')</option>';
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

}


function select_formulation(wd_id){
	current_drug.formulation = $("#blk_drug_formulation_list option:selected").text();
	current_drug.wd_id = wd_id;
	current_drug.name = $("#blk_drug_name_list option:selected").text();
	current_drug.dose = null;
	current_drug.frequency = null;
	current_drug.period = null;	
	load_dose();
	//load_frequency();
	enable_button();
	
}

function set_default_value(wid){
	if (drug_list.length>0){
		for (i in drug_list){
			if (drug_list[i].wd_id == wid){
				$("#blk_drug_dose_list").val(drug_list[i].default_num);
				$("#blk_drug_period_list").val("For 3 days");
				$("#blk_drug_fq_list").val(drug_list[i].default_timing);
				current_drug.dose =drug_list[i].default_num;
				current_drug.frequency = drug_list[i].default_timing;
				current_drug.period = "For 3 days";	
				update_form();
				//$("#blk_drug_fq_list").filter(function() {
				//	return $(this).text()=="per day"; 
				//}).prop('selected', true);
			}
		}
	}
}

function load_frequency(){
	current_drug.frequency = null;
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_frequency",
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		var data = eval('('+response+')');
		
			if (!$("#blk_drug_fq").get(0) ){
				$("#blk_2_content").append('<td id="blk_drug_fq" width=1%></td>');
			}
			$("#blk_drug_fq").html('');
			
			$("#blk_drug_fq").append('<b>Frequency</b><br>');
			$("#blk_drug_fq").append('<select class="input" id="blk_drug_fq_list" onchange=select_fq(this.value) size=15 style="height:330px;width:100px;"></select>');
			$("#blk_drug_fq_list").html('');
			try{
				for (var i=0; i<data.length; i++){
					$("#blk_drug_fq_list").append('<option value="'+data[i]["Frequency"]+'" title="'+data[i]["Frequency"]+'">'+data[i]["Frequency"]+'</option>');
				}
			}catch(e){
			}
			load_period();
	});
	enable_button();
}


function load_dose(){
	current_drug.dose = null;	
	
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_dosage",
	type: "post"
	});

	request.done(function (response, textStatus, jqXHR){
	var dose = eval('('+response+')');
			
	if (!$("#blk_drug_dose").get(0) ){
		$("#blk_2_content").append('<td id="blk_drug_dose" width=1%></td>');
		
	}
	$("cc").html('');
	$("#blk_drug_dose").append('<b>Dose</b><br>');
	$("#blk_drug_dose").append('<select class="input" id="blk_drug_dose_list" onchange=select_dose(this.value) size=15 style="height:330px;width:80px;"></select>');
	$("#blk_drug_dose_list").html('');
	$("#add_cont").html('');
	try{
		for (var i=0; i<dose.length; i++){
			$("#blk_drug_dose_list").append('<option value="'+dose[i]["Dosage"]+'" title="'+dose[i]["Dosage"]+'">'+dose[i]["Dosage"]+'</option>');
			
		}
	}catch(e){
	}	
	load_frequency();
	});
	enable_button();
}

/*
function load_period(){
	current_drug.period = null;	

	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/lookup/get_period",
	type: "post"
	});

	request.done(function (response, textStatus, jqXHR){
	var period = eval('('+response+')');
	
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
			$("#blk_drug_period_list").append('<option value="'+period[i]["Period"]+'" title="'+period[i]["Period"]+'">'+period[i]["Period"]+'</option>');
		}
	}catch(e){
	}	
	enable_button();
	});
}
*/
function load_period(){
	current_drug.period = null;	
	var period = new Array('For 1 day','For 2 days','For 3 days','For 4 days','For 5 days','For 1 week','For 2 weeks','For 3 weeks','For 1 month');
	if (!$("#blk_drug_period").get(0) ){
		$("#blk_2_content").append('<td id="blk_drug_period" width=1%></td>');
	}
	$("#blk_drug_period").html('');
	$("#blk_drug_period").append('<b>Period</b><div id="selected_period" class="selected">');
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
	update_form();
}

function select_dose(dose_id){
	current_drug.dose = $("#blk_drug_dose  option:selected").val();
	$("#Dose").val(current_drug.dose);
	update_form();
}

function select_period(period){
	current_drug.period = $("#blk_drug_period_list option:selected").text();
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
	if ($("#add_btn").length ==0){
		//$("#blk_2_content").append('<button type="button" class="btn btn-primary btn-lg btn-block" onclick=$("#drug_form").submit(); id="add_btn" >+Add</button>')
	}
	$("#add_cont").html('<button type="button" class="btn btn-primary btn-lg btn-block" onclick=$("#drug_form").submit(); >+ADD</button>');
	update_form();
}

function update_form(){
	$("#Frequency").val(current_drug.frequency);
	$("#HowLong").val(current_drug.period);
	$("#Dose").val(current_drug.dose);
	$("#wd_id").val($("#blk_drug_name_list").val());
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
				var PRES_ID =null;
				for (var i=0; i<data.length; i++){
					PRES_ID = data[i]["PRES_ID"];
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
				$("#add_cont").html('<button type="button" class="btn btn-primary btn-lg btn-block" onclick=prescribe_all("'+PRES_ID+'"); >+Repeat All</button>');
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
function prescribe_all(id){
	if (id=="") return;
	var request = $.ajax({
		url: "<?php echo base_url(); ?>index.php/opd/prescribe_all/"+id+"/"+$("#PID").val()+"/"+$("#OPDID").val(),
		type: "post"
	});
	request.done(function (response, textStatus, jqXHR){
		if(response>0){
			self.document.location = "<?php echo base_url(); ?>index.php/opd/prescription/"+response+"?CONTINUE=opd/view/"+$("#OPDID").val();
		}
	});
}
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