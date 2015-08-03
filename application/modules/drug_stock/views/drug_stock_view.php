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

	include_once("header.php");	///loads the html HEAD section (JS,CSS)

?>
<?php echo Modules::run('menu'); //runs the available menu option to that usergroup ?>

	<div class="container" style="width:95%;">
		<div class="row" style="margin-top:55px;">
		  <div class="col-md-2 ">
			<?php //echo Modules::run('leftmenu/questionnaire'); //runs the available left menu for preferance ?>
			<?php 
					echo Modules::run('leftmenu/preference'); //runs the available left menu for preferance 
			?>
		  </div>
		  <div class="col-md-10 ">
		  		<?php 
					if (isset($error)){
						echo '<div class="alert alert-danger"><b>ERROR:</b>'.$error.'</div>';
						exit;
					}
					
				?>		  
				<div class="panel panel-default"  >
					<div class="panel-heading"><b>Stock Management </b>
					</div>
					<div class="well well-sm">
						<?php
							if ( empty($drug_stock_list)) {
									echo 'No stock available. <a href="'.site_url("form/create/drug_stock?CONTINUE=drug_stock/view").'">Add a new stock</a>';
							}
							else{
								echo '<b>Available stocks</b><a class="pull-right btn-xs btn-warning" href="'.site_url("form/create/drug_stock?CONTINUE=drug_stock/view").'">Add new</a>';
								if ($this->config->item('purpose') !="PP"){
									echo '<br><br> Please select one of the below stock to see the drugs inventory detail.';
								}else{
									echo '<br><br> OPD drugs inventory detail.';
								}
								echo '<div>';
								for ($i =0; $i<count($drug_stock_list); ++$i){
									echo '<a class=" btn ';
									if (isset($drug_stock_info) && ($drug_stock_info["drug_stock_id"]==$drug_stock_list[$i]["drug_stock_id"]) ){
										echo ' btn-success ';
									}
									else{
										echo ' btn-default ';
									}
									echo ' "';
									echo ' href="'.site_url("drug_stock/view/".$drug_stock_list[$i]["drug_stock_id"]).'">'.$drug_stock_list[$i]["name"].'</a>&nbsp;';
								}
								echo '</div>';
							}
							
						?>
						
					</div>
				</div>
				<div class="panel panel-default"  >
					<div class="panel-heading"><b>
					<?php
						if (isset($drug_stock_info)){
							echo $drug_stock_info["name"].'&nbsp;';
						}
					?>
					Stock inventory </b>
					</div>
					<?php
						if (!empty($drug_count_list)){
							echo '<table class="table table-condensed table-bordered table-striped table-hover">';
								echo '<tr>';
									echo '<th>';
									echo 'Drug Name';
									echo '</th>';
									echo '<th>';
									echo 'In Stock';
									echo '</th>';
									//echo '<th>';
									//echo 'Option';
									//echo '</th>';
								echo '</tr>';
								for ($i=0; $i<count($drug_count_list); ++$i){
									echo '<tr>';
									echo '<td>';
									echo $drug_count_list[$i]["name"];
									echo '-';
									echo $drug_count_list[$i]["formulation"];
									echo '-';
									echo $drug_count_list[$i]["dose"];
									echo '</td>';
									echo '<td >';
										echo '<span id="cell_'.$drug_count_list[$i]["drug_count_id"].'"  ';
											if ($drug_count_list[$i]["who_drug_count"] > $this->config->item('drug_alert_count')){
												echo ' class="label label-success">';
											}
											else{
												echo ' class="label label-warning">';
											}
												echo $drug_count_list[$i]["who_drug_count"];
										echo '</span>';
									echo '</td>';
									echo '<td >';
										echo ' <input  id="inp_'.$drug_count_list[$i]["drug_count_id"].'"type="number" class=""  min=0 step=100 value="" >';
										echo ' <input  id="btn_'.$drug_count_list[$i]["drug_count_id"].'" type="button" onclick=add_stock("'.$drug_count_list[$i]["drug_count_id"].'") class="btn btn-default btn-sm" value="Add" >';
									echo '</td>';
								echo '</tr>';
								}
							echo '</table>';
						}
						
					?>
				</div>
			</div>
		</div>
	</div>
	<script language="javascript">
		function add_stock(drug_count_id){
			var who_drug_count = parseInt($(String("#inp_"+drug_count_id)).val());
			var current_count = $("#cell_"+drug_count_id).html();
			if (current_count==""){
				current_count =0;
			}
			if (who_drug_count){
				who_drug_count = parseInt(parseInt(+who_drug_count)+parseInt(+current_count));
				var request = $.ajax({
					url: "<?php echo base_url(); ?>index.php/drug_stock/add_stock/",
					type: "post",
					data:{"drug_count_id":drug_count_id,"who_drug_count":who_drug_count}
				});
				request.done(function (response, textStatus, jqXHR){
					if(response == drug_count_id){
						$("#cell_"+response).html(who_drug_count).removeClass("label-warning").addClass("label-success");
						$("#inp_"+response).val("");
					}
				});
			}
		}
	</script>
	