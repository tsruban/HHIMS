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
$form["OBJID"] = "clinic_diagram_id";
$form["TABLE"] = "clinic_diagram";
$form["FORM_CAPTION"] = "Clinical Diagam";
$form["SAVE"] = "diagram/save";
$form["UNIQUE_ID"]  = TRUE; // IF TRUE ITS GENERATE A UNIQUE ID INSTEAD OF A-I
$form["CREATE_DISCRIPTION"] = "";
$form["EDIT_DISCRIPTION"] = " Editing this diagram data, will affect all modules, which are using this diagram.";
$form["CONTINUE"]  = "";	// default page after saving 
//pager starts
$form["CAPTION"]  = "<input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/clinic_diagram')."\' value=\'Add new diagram\'>";
$form["ACTION"]  = base_url()."index.php/diagram/view/";
$form["ROW_ID"]="clinic_diagram_id";
$form["COLUMN_MODEL"] = array( 'clinic_diagram_id'=>array("width"=>"35px"), 'name', 'description', 'diagram_name','diagram_type','active');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'clinic_diagram_id','CreateDate', 'name', 'description',  'diagram_name','diagram_type','active');
$form["DISPLAY_LIST"] = array( '#', 'Create Date','Name',  'Description','File','Type', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"name", 
		"name"=>"name",
		"label"=>"* Name",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Diagram name",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"diagram_type", 
		"name"=>"diagram_type",
		"label"=>"*Diagram type",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("ABDOMEN","MALE","FEMALE"),
		"placeholder"=>"",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),	
	array(		
		"id"=>"diagram_name", 
		"name"=>"diagram_name",
		"label"=>"* File",
		"type"=>"file",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"description", 
		"name"=>"description",
		"label"=>"Description",
		"type"=>"remarks",
		"value"=>"",
		"option"=>" ",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
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
			"value"=>"question",
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