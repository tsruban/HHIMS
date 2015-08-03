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


////////Configuration for patient form
$form = array();
$form["OBJID"] = "wd_id";
$form["TABLE"] = "who_drug";
$form["FORM_CAPTION"] = "Drugs";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/who_drug";	
//pager starts
$form["CAPTION"]  = "Drugs <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/who_drug')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/who_drug/";
$form["ROW_ID"]="wd_id";
$form["COLUMN_MODEL"] = array( 'wd_id'=>array("width"=>"35px"), '`group`', 'sub_group', 'name', 'formulation', 'dose');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'wd_id', '`group`', 'sub_group', 'name', 'formulation', 'dose');
$form["DISPLAY_LIST"] = array( 'wd_id', 'Group', 'Sub_group', 'Name', 'Formulation', 'Dose');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"group", 
		"name"=>"group",
		"label"=>"*Drug Group",
		"type"=>"text",
		"width"=>"15px",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Drug Group",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"sub_group", 
		"name"=>"sub_group",
		"label"=>"*Drug sub group",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Drug Group",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"name", 
		"name"=>"name",
		"label"=>"*Drug Name",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"complaints",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"dose", 
		"name"=>"dose",
		"label"=>"*Dose",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Dose eg.90mg",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"default_num", 
		"name"=>"default_num",
		"label"=>"*Default Dosage",
		"type"=>"number",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"1 2 3 etc",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"default_timing", 
		"name"=>"default_timing",
		"label"=>"*Default frequency",
		"type"=>"number",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"1 2 3 etc",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),		
array(		
		"id"=>"formulation", 
		"name"=>"formulation",
		"label"=>"*Formulation",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Formulation",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	)
	);

$patient["JS"] = "
<script>
function ForceSave(){
}
</script>
";  									
////////Configuration for patient form END;                   
?>