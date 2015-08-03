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


////////Configuration for qu_module form
$form = array();
$form["OBJID"] = "qu_module_id";
$form["TABLE"] = "qu_module";
$form["FORM_CAPTION"] = "Module";
$form["UNIQUE_ID"]  = TRUE; // IF TRUE ITS GENERATE A UNIQUE ID INSTEAD OF A-I
$form["SAVE"] = "";
if (isset($_POST["qu_module_id"])&& $_POST["qu_module_id"]>0){
	$form["NEXT"]  = "module/open/".$_POST["qu_module_id"];	
}
else{
	$form["NEXT"]  = "module";
}

//pager starts
$form["CAPTION"]  = "Available modules <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/qu_module')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/module/open/";
$form["ROW_ID"]="qu_module_id";
$form["COLUMN_MODEL"] = array( 'qu_module_id'=>array("width"=>"35px"), 'name', 'code', 'description', 'applicable_to', 'active');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'qu_module_id', 'Name', 'code', 'description', 'applicable_to', 'active');
$form["DISPLAY_LIST"] = array( '#', 'Name','Code', 'Description', 'Applicable to', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"name", 
		"name"=>"name",
		"label"=>"Name",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Name of the Module",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"code", 
		"name"=>"code",
		"label"=>"*Code",
		"type"=>"text",
		"value"=>"",
		"option"=>" ",
		"placeholder"=>"Code of the module eg. CACLIN1",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"description", 
		"name"=>"description",
		"label"=>"Description",
		"type"=>"textarea",
		"value"=>" ",
		"option"=>" ",
		"placeholder"=>"Description",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"applicable_to", 
		"name"=>"applicable_to",
		"label"=>"*Applicable to",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("Male","Female","Both"),
		"placeholder"=>"",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),
	array(		
		"id"=>"show_in", 
		"name"=>"show_in",
		"label"=>"*Show in",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("Patient","OPD","Admission","Clinic","ALL"),
		"placeholder"=>"",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),
	array(		
		"id"=>"active", 
		"name"=>"active",
		"label"=>"Active",
		"type"=>"boolean",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required",
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