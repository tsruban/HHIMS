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
//if anything you need to store on session.

//echo $this->session->userdata("qu_questionnaire_id").'xxxxxxxx';
$form = array();
$form["OBJID"] = "qu_select_id";
$form["TABLE"] = "qu_select";
$form["FORM_CAPTION"] = "Select option";
$form["UNIQUE_ID"]  = TRUE; // IF TRUE ITS GENERATE A UNIQUE ID INSTEAD OF A-I
$form["SAVE"] = "";
$form["EDIT_DISCRIPTION"] = " Editing this select data, will affect all questionnaires, which are using this select option.";
//pager starts
$form["CAPTION"]  = "Available modules <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/qu_module')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/questionnaire/open/";
$form["ROW_ID"]="qu_question_id";
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"select_text", 
		"name"=>"select_text",
		"label"=>"Select text",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Txt",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"select_value", 
		"name"=>"select_value",
		"label"=>"*Select value",
		"type"=>"text",
		"value"=>"",
		"option"=>" ",
		"placeholder"=>"Value of he option",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"select_default", 
		"name"=>"select_default",
		"label"=>"Default value",
		"type"=>"text",
		"value"=>"",
		"option"=>" ",
		"placeholder"=>"Defailt value of he option",
		"rules"=>"trim|xss_clean",
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
		"id"=>"qu_question_id", 
		"name"=>"qu_question_id",
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