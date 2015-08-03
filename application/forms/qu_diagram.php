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
$form["OBJID"] = "qu_diagram_id";
$form["TABLE"] = "qu_diagram";
$form["FORM_CAPTION"] = "Select diagram";
$form["UNIQUE_ID"]  = TRUE; // IF TRUE ITS GENERATE A UNIQUE ID INSTEAD OF A-I
$form["SAVE"] = "";
$form["EDIT_DISCRIPTION"] = " Editing this data, will affect all questionnaires, which are using this diagram.";
//pager starts
$form["CAPTION"]  = "";
$form["ACTION"]  = base_url()."index.php/questionnaire/open/";
$form["ROW_ID"]="qu_question_id";
//pager ends
$form["FLD"]=array(
	array(		
		"id"=>"cln_diagram_id", 
		"name"=>"cln_diagram_id",
		"label"=>"* Clinic diagram ",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'clinic_diagram_id',
		"sql"=>"SELECT clinic_diagram_id ,name  as cln_diagram_id
		FROM clinic_diagram WHERE (Active = TRUE)
		 ORDER BY name ",
		"placeholder"=>"Ward",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"edit_access"=>array("","Admin")
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