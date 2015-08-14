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


////////Configuration for opd_visits form
$form = array();
$form["OBJID"] = "ADMDIAGNOSISID";
$form["TABLE"] = "admission_diagnosis";
$form["SAVE"] = "";
$form["NEXT"]  = "admission/view";	// default page after saving 
$form["CONTINUE"]  = "";	//this can be filled when you want to coustomize what page to go after saving 
$form["PATIENT_BANNER_ID"] = "";

$form["FORM_CAPTION"] = "Diagnosis";
//pager starts
//pager ends	
$form["FLD"]=array(
array(		
		"id"=>"DiagnosisDate", 
		"name"=>"DiagnosisDate",
		"label"=>"*Date of diagnosis",
		"type"=>"timestamp",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
	array(		
		"id"=>"SNOMED_Text", 
		"name"=>"SNOMED_Text",
		"label"=>"SNOMED",
		"type"=>"SNOMED_DIAGNOSIS",
		"value"=>" ",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean|required",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array()
	),	
array(		
		"id"=>"SNOMED_Code", 
		"name"=>"SNOMED_Code",
		"label"=>"",
		"type"=>"hidden",
		"value"=>" ",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array()
	),	
array(		
		"id"=>"ICD_Text", 
		"name"=>"ICD_Text",
		"label"=>"ICD",
		"type"=>"text",
		"value"=>'',
		"option"=>"readonly",
		"placeholder"=>"Icd",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array()
	),	
array(		
		"id"=>"ICD_Code", 
		"name"=>"ICD_Code",
		"label"=>"",
		"type"=>"hidden",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Icd",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array()
	),	
array(		
		"id"=>"IMMR_Text", 
		"name"=>"IMMR_Text",
		"label"=>"IMMR",
		"type"=>"text",
		"value"=>'',
		"option"=>"readonly",
		"placeholder"=>"IMMR",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array()
	),	
array(		
		"id"=>"IMMR_Code", 
		"name"=>"IMMR_Code",
		"label"=>"",
		"type"=>"hidden",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"IMMR",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array()
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
	),
array(		
		"id"=>"ADMID", 
		"name"=>"ADMID",
		"label"=>"",
		"type"=>"hidden",
		"value"=>$this->uri->segment(4),
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required|xss_clean",
		"class"=>"input",
		"style"=>""
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
			"value"=>"admission/view".$this->uri->segment(4),
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