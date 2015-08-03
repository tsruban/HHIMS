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
$form["OBJID"] = "qu_questionnaire_id";
$form["TABLE"] = "qu_questionnaire";
$form["SAVE"] = "";
$form["FORM_CAPTION"] = "Questionnire";
$form["CONTINUE"]  = "";	// default page after saving 
$form["UNIQUE_ID"]  = TRUE; // IF TRUE ITS GENERATE A UNIQUE ID INSTEAD OF A-I
//pager starts
$form["CAPTION"]  = "Available Questionnaires <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/qu_questionnaire')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/questionnaire/open/";
$form["ROW_ID"]="qu_questionnaire_id";
$form["COLUMN_MODEL"] = array( 'qu_questionnaire_id'=>array("width"=>"35px"), 'name', 'code', 'description', 'applicable_to', 'active');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'qu_questionnaire_id', 'Name', 'code', 'description', 'applicable_to', 'active');
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
		"placeholder"=>"Name of the questionnaire",
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
		"placeholder"=>"Code of the questionnaire eg. CACLIN1",
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
		"id"=>"show_in_patient", 
		"name"=>"show_in_patient",
		"label"=>"*Show in patient screen",
		"type"=>"boolean",
		"value"=>" ",
		"placeholder"=>"",
		"rules"=>"",
		"style"=>"",
		"class"=>"input"
	),
	array(		
		"id"=>"show_in_admission", 
		"name"=>"show_in_admission",
		"label"=>"*Show in admission screen",
		"type"=>"boolean",
		"value"=>"",
		"placeholder"=>"",
		"rules"=>"",
		"style"=>"",
		"class"=>"input"
	),
/*
array(		
		"id"=>"Doctor", 
		"name"=>"Doctor",
		"label"=>"*Doctor ",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'UID',
		"sql"=>"SELECT UID,CONCAT(Title,FirstName,' ',OtherName ) as Doctor 
		FROM user WHERE (Active = TRUE) AND ((Post = 'OPD Doctor') OR (Post = 'Consultant')) 
		 ORDER BY OtherName ",
		"placeholder"=>"Doctor",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"edit_access"=>array("","Admin")
	),	
*/	
array(		
		"id"=>"show_in_clinic", 
		"name"=>"show_in_clinic",
		"label"=>"*Show in clinic ",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'clinic_id',
		"sql"=>"SELECT clinic_id,Name as show_in_clinic	 FROM clinic WHERE Active = TRUE 
		 ORDER BY Name " ,
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","Admin")
	),	
array(		
		"id"=>"show_in_visit", 
		"name"=>"show_in_visit",
		"label"=>"*Show in visit ",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'VTYPID',
		"sql"=>"SELECT VTYPID,Name as show_in_visit	 FROM visit_type WHERE Active = TRUE 
		 ORDER BY Name " ,
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","Admin")
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
			"value"=>"questionnaire",
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