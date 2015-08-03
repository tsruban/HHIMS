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
				echo '<div class="alert alert-info" style="margin-bottom:1px;padding-top:8px;padding-bottom:8px">';
				echo '<a href="'.site_url("admission/drug_chart/".$admission_presciption_info["admission_prescription_id"]."/Once only").'" type="button" class="btn  btn-default btn" id="once_only"  >Once only</a>';
				echo '&nbsp;<a href="'.site_url("admission/drug_chart/".$admission_presciption_info["admission_prescription_id"]."/Regular").'" type="button" class="btn  btn-default btn"  id="regular">Regular</a>';
				echo '&nbsp;<a href="'.site_url("admission/drug_chart/".$admission_presciption_info["admission_prescription_id"]."/As-Needed").'" type="button" class="btn  btn-default btn" id="as_needed" >As-Required</a>';
				echo '&nbsp;<a href="'.site_url("admission/view/".$admission_info["ADMID"]).'" type="button" class="btn  btn-default btn"  >Back to admission</a>';
				
				echo '</div>';
			}
		?>
		<div class="panel panel-default  "  style="padding:2px;margin-bottom:1px;" >
			<div class="panel-heading" ><b><CENTER>PRESCRIPTION AND ADMINISTRATION RECORD<BR>including the Warfarin Chart</CENTER></b>
			</div>
			<div class="" style="margin-bottom:1px;padding-top:8px;">
				<?php 
					echo '<table class="table table-condensed " style="margin-bottom:0px;" border=0>';
						echo '<tr>';
							echo '<td width=50%>';
								echo '<div class="well well-sm">';
								echo '<div class="row">';
								  echo '<div class="col-md-5">';
									echo 'Hospital : <br><b >'.$this->session->userdata("Hospital").'</b>';
									echo '<br>Ward : <b >'.$admission_info["Ward"].'</b>';
								  echo '</div>';
								  echo '<div class="col-md-5">';
									echo 'Consultant : <br><b >'.$admission_info["Doctor"].'</b>';
									echo '<br>Height : <b ></b>';
									echo '<br>weight : <b ></b>';
								  echo '</div>';
								echo '</div>';
								
								echo '</div>';
							echo '</td>';
							echo '<td>';
							echo '<div class="well well-sm">';
									echo 'Patient : <b >';
									echo  $patient_info["Personal_Title"];
									echo  $patient_info["Personal_Used_Name"]."&nbsp;";
									echo  $patient_info["Full_Name_Registered"];
									echo '</b>';
									echo '<br>HIN : <b >'.$patient_info["HIN"].'</b>';
									echo '<br>Date of Birth : <b >';
									if ($patient_info["Age"]["years"]>0){
										echo  $patient_info["Age"]["years"]."Yrs&nbsp;";
									}
									echo  $patient_info["Age"]["months"]."Mths&nbsp;";
									echo  $patient_info["Age"]["days"]."Dys&nbsp;";
									echo '</b>';
									echo '<br>BHT : <b >'.$admission_info["BHT"].'</b>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						/*
						echo '<tr>';
						
							echo '<td colspan=2>';
								echo '<div class="well well-sm">';
								echo '</div>';
							echo '</td>';
						echo '</tr>';	
						*/
					echo '</table>';	
					echo '<center><h4><b>ONCE ONLY</b></h4></center>';
					//print_r($opd_presciption_info);
					//<th>Frequency</th>
					if (isset($prescribe_items_list)){
						echo '<table class="table table-condensed table-hover" style="margin-bottom:0px;" border=1>';
						echo '<tr style="background:#e2e2e2;"><th width=20>#</th><th width=150 nowrap>Date</th><th>Name</th><th width=50>Dose</th>
						<th width=50>Type</th>
						<th width=150>Prescriber</th>';
						echo '<th width=50 >Given date</th>';
						echo '<th width=50 >Time</th>';
						echo '<th width=50 >Given?</th>';
						echo '<th width=50 ></th>';

						echo '</tr>';
							for($i=0; $i < count($prescribe_items_list);++$i){
							//if ($prescribe_items_list[$i]["is_given"] ==1) continue;
							//print_r($prescribe_items_list[$i]);
								echo '<tr  role="'.$prescribe_items_list[$i]["d_type_id"].'" ';
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
										echo $prescribe_items_list[$i]["drug_name"]. ' - '.$prescribe_items_list[$i]["drug_dose"];
									echo '</td>';
									echo '<td>';
										echo $prescribe_items_list[$i]["Dosage"];
									echo '</td>';
									//echo '<td>';
										//echo $prescribe_items_list[$i]["Frequency"];
									//echo '</td>';
									
									
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
									echo '<td>';
										echo character_limiter($prescribe_items_list[$i]["CreateUser"],15);
									echo '</td>';
									echo '<td width=102px>';
									if ($prescribe_items_list[$i]["is_given"] ==1){
										$d = explode(" ", $prescribe_items_list[$i]["given_date_time"]);
										echo $d[0];
									}else{
										echo '<input style="width:100px" type="text" value="'.date("Y-m-d").'" id="given_date_'.$prescribe_items_list[$i]["prescribe_items_id"].'" name="given_date_'.$prescribe_items_list[$i]["prescribe_items_id"].'"
										onmousedown=$("#given_date_'.$prescribe_items_list[$i]["prescribe_items_id"].'").datepicker({changeMonth:true,changeYear:true,yearRange:"c-40:c+40",dateFormat:"yy-mm-dd",maxDate:"+0D"});  
										>';
									}
									echo '</td>';
									echo '<td>';
									if ($prescribe_items_list[$i]["is_given"] ==1){
										$d = $pieces = explode(" ", $prescribe_items_list[$i]["given_date_time"]);
										echo $d[1];
									}else{
										echo '<select style="width:50px" id="given_time_'.$prescribe_items_list[$i]["prescribe_items_id"].'" name="given_time_'.$prescribe_items_list[$i]["prescribe_items_id"].'" >';
										for ($h=0; $h<24; ++$h){
											for ($m=0; $m<60; $m=$m+30){
												$tm = $h.':';
												if ( $m==0 ){ $tm .= '00';}
												else { $tm .= $m;}
												echo '<option vale="'.$tm.'">'.$tm;
												
												echo '</option>';;
											}
											$m=0;
										}
										echo '</select>';
									}
									echo '</td>';
									
									echo '<td>';
									if ($prescribe_items_list[$i]["is_given"] ==1){
										echo 'Yes  <span class="glyphicon glyphicon-ok"></span>';
									}else{
										echo '<select style="width:50px" id="is_given_'.$prescribe_items_list[$i]["prescribe_items_id"].'" name="is_given_'.$prescribe_items_list[$i]["prescribe_items_id"].'">';
										echo '<option value=""></option>';
										echo '<option value=1>Yes</option>';
										echo '</select>';
									}
									echo '</td>';
									echo '<td>';
									if ($prescribe_items_list[$i]["is_given"] !=1){
										echo '<button onclick=update_drug("'.$prescribe_items_list[$i]["prescribe_items_id"].'") class="btn  btn-default btn-xs"  >Save</button>';
									}
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
					//echo '<center><a href="'.site_url("admission/view/".$admission_info["ADMID"]).'" type="button" class="btn  btn-default btn"  >Back to admission</a></center>';
					
					if ($admission_info["OutCome"]) {
							echo '</div>';
							exit;
					}
				?>				

		</div>	
	</div>

	</div>
</div>
<script language="javascript">
	function update_drug(id){
		if (id=="") return;
		
		var is_given = $("#is_given_"+id).val();
		if (is_given=="") {
			alert("Is the drug given?");
			return;
		}
		var given_date = $("#given_date_"+id).val();
		var given_time = $("#given_time_"+id).val();
		var data = {"prescribe_items_id":id, 
					"is_given":is_given, 
					"given_date":given_date,
					"given_time":given_time};
		var request = $.ajax({
			url: "<?php echo base_url(); ?>index.php/admission/update_only_once/",
			type: "post",
			data:data
		});
		request.done(function (response, textStatus, jqXHR){
			location.reload();
		});
	}
	function init(){
		var d_type="<?php echo $d_type; ?>";
		if (d_type =="Once%20only"){
			$("#once_only").removeClass("btn-default");
			$("#once_only").addClass("btn-primary");
			$("#regular").removeClass("btn-primary");
			$("#as_needed").removeClass("btn-primary");
		}
		else if(d_type =="Regular"){
			$("#regular").removeClass("btn-default");
			$("#regular").addClass("btn-primary");
			$("#once_only").removeClass("btn-primary");
			$("#as_needed").removeClass("btn-primary");
		}
		else{
			$("#as_needed").removeClass("btn-default");
			$("#as_needed").addClass("btn-primary");
			$("#once_only").removeClass("btn-primary");
			$("#regular").removeClass("btn-primary");
		}
	}
$(function(){
	init();
	
});

</script>