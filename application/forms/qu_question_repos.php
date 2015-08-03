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
$form["OBJID"] = "qu_question_repos_id";
$form["TABLE"] = "qu_question_repos";
$form["FORM_CAPTION"] = "Question Repository";
$form["SAVE"] = "";
$form["UNIQUE_ID"]  = TRUE; // IF TRUE ITS GENERATE A UNIQUE ID INSTEAD OF A-I
$form["CREATE_DISCRIPTION"] = "";
$form["EDIT_DISCRIPTION"] = " Editing this question data, will affect all questionnaires, which are using this question.";
$form["CONTINUE"]  = "";	// default page after saving 
//pager starts
$form["CAPTION"]  = "<input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/qu_question_repos')."\' value=\'Add new question\'>";
$form["ACTION"]  = base_url()."index.php/question/view/";
$form["ROW_ID"]="qu_question_repos_id";
$form["COLUMN_MODEL"] = array( 'qu_question_repos_id'=>array("width"=>"35px"), 'question', 'code', 'applicable_to','question_type','qu_group', 'active');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'qu_question_repos_id', 'question', 'code',  'applicable_to','question_type','qu_group', 'active');
$form["DISPLAY_LIST"] = array( '#', 'Question','Code',  'Applicable to','Data type','Type', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"question", 
		"name"=>"question",
		"label"=>"* Question",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Question",
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
		"placeholder"=>"Code of the question eg. QCACLIN1",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"question_type", 
		"name"=>"question_type",
		"label"=>"*Question type",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("Text","TextArea","Number","ICD","IMMR","SNOMED_FINDING","SNOMED_EVENT","SNOMED_PROCEDURE","SNOMED_DISORDER","Date","Select","MultiSelect","Yes_No","Header","Footer","PAIN_DIAGRAM"),
		"placeholder"=>"",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"qu_group", 
		"name"=>"qu_group",
		"label"=>"* Category ",
		"type"=>"select",
		"value"=>'',
		"option"=>array("DEMOGRAPHIC","CLINICAL","PERSONAL","OTHER"),
		"placeholder"=>"",
		"rules"=>"trim|xss_clean|required",
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
		"id"=>"help", 
		"name"=>"help",
		"label"=>"Help",
		"type"=>"textarea",
		"value"=>" ",
		"option"=>" ",
		"placeholder"=>"Description/Help text",
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