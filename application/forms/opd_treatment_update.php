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


////////Configuration for opd_treatment form
$form = array();
$form["OBJID"] = "OPDTREATMENTID";
$form["TABLE"] = "opd_treatment";
$form["SAVE"] = "form/save/opd_treatment_update";
$form["SAVE_TABLE"] = "opd_treatment";
$form["NEXT"]  = "";	// default page after saving 
$form["CONTINUE"]  = "";	//this can be filled when you want to coustomize what page to go after saving 

$form["FORM_CAPTION"] = "OPD Treatment";
//pager starts
$form["CAPTION"]  = "Allergy list";
$form["ACTION"]  = base_url()."index.php/form/edit/opd_treatment/";
$form["ROW_ID"]="OPDTREATMENTID";
$form["COLUMN_MODEL"] = array();
$form["ORIENT"] = "L";
$form["LIST"] = array( 'OPDTREATMENTID');
$form["DISPLAY_LIST"] = array( 'ID');
//pager ends	
$form["FLD"]=array(

array(		
		"id"=>"Treatment", 
		"name"=>"Treatment",
		"label"=>"Treatment",
		"type"=>"label",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"",
		"style"=>"",
		"class"=>"input"
	),	
	array(		
		"id"=>"Status", 
		"name"=>"Status",
		"label"=>"Status",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("Done","Pending"),
		"placeholder"=>"",
		"rules"=>"",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Remarks", 
		"name"=>"Remarks",
		"label"=>"Remarks",
		"type"=>"remarks",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Any remarks",
		"rules"=>"xss_clean",
		"class"=>"input",
		"style"=>"",
		"rows"=>"2",
		"cols"=>"300"
	)
	);
if (isset($_GET["CONTINUE"])){
array_push ($form["FLD"],
	array(		
			"id"=>"CONTINUE", 
			"name"=>"CONTINUE",
			"label"=>"",
			"type"=>"hidden",
			"value"=>$_GET["CONTINUE"],
			"option"=>"",
			"placeholder"=>"",
			"rules"=>"xss_clean",
			"class"=>"input",
			"style"=>""
		)
	);
}
else{
array_push ($form["FLD"],
	array(		
			"id"=>"CONTINUE", 
			"name"=>"CONTINUE",
			"label"=>"",
			"type"=>"hidden",
			"value"=>"opd/view/".$this->uri->segment(4),
			"option"=>"",
			"placeholder"=>"",
			"rules"=>"xss_clean",
			"class"=>"input",
			"style"=>""
		)
	);
}
$patient["JS"] = "
<script>
function ForceSave(){
}
</script>
";  									
////////Configuration for patient form END;                   
?>