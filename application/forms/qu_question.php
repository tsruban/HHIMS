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


////////Configuration for Question form
$form = array();
$form["OBJID"] = "qu_question_id";
$form["TABLE"] = "qu_question";
$form["FORM_CAPTION"] = "Question";
$form["UNIQUE_ID"]  = TRUE; // IF TRUE ITS GENERATE A UNIQUE ID INSTEAD OF A-I
$form["SAVE"] = "";
if (isset($_POST["qu_questionnaire_id"])){
	$form["NEXT"]  = "questionnaire/open/".$_POST["qu_questionnaire_id"];	
}
else{
	$form["NEXT"]  = "questionnaire/open/".$this->uri->segment(4);	
}
//pager starts
$form["CAPTION"]  = "Available modules <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/qu_module')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/questionnaire/open/";
$form["ROW_ID"]="qu_question_id";
$form["COLUMN_MODEL"] = array( 'qu_question_id'=>array("width"=>"35px"), 'name', 'code', 'description', 'applicable_to', 'active');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'qu_question_id', 'Name', 'code', 'description', 'applicable_to', 'active');
$form["DISPLAY_LIST"] = array( '#', 'Name','Code', 'Description', 'Applicable to', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"question", 
		"name"=>"question",
		"label"=>"Question",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Your question",
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
		"placeholder"=>"Code of the question eg. Q1",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"help", 
		"name"=>"help",
		"label"=>"Help",
		"type"=>"textarea",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Some help for the question",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"question_type", 
		"name"=>"question_type",
		"label"=>"*Question type",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("Text","TextArea","Number","ICD","IMMR","SNOMED_FINDING","SNOMED_EVENT","SNOMED_PROCEDURE","SNOMED_DISORDER","Date","Select","MultiSelect","Radio","Yes_No","Header"),
		"placeholder"=>"",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),
	array(		
		"id"=>"default_ans", 
		"name"=>"default_ans",
		"label"=>"Default answer",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Default answer if any",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
	array(		
		"id"=>"applicable_to", 
		"name"=>"applicable_to",
		"label"=>"*Applicable to",
		"type"=>"select",
		"value"=>"",
		"option"=>array("Male","Female","Both"),
		"placeholder"=>"",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),	
		array(		
		"id"=>"order", 
		"name"=>"order",
		"label"=>"Question order",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>" Order of the question in the form",
		"rules"=>"required|numeric",
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
	),
	array(		
		"id"=>"qu_questionnaire_id", 
		"name"=>"qu_questionnaire_id",
		"label"=>"",
		"type"=>"hidden",
		"value"=>$this->uri->segment(4),
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