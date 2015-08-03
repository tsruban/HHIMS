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


////////Configuration for patient_exam form
$form = array();
$form["OBJID"] = "PATEXAMID";
$form["TABLE"] = "patient_exam";
$form["SAVE"] = "";
$form["NEXT"]  = "patient/view";	// default page after saving 
$form["CONTINUE"]  = "";	//this can be filled when you want to coustomize what page to go after saving 
$form["PATIENT_BANNER_ID"] = $this->uri->segment(4);


$form["FORM_CAPTION"] = "Examination";
//pager starts
$form["CAPTION"]  = "Allergy list";
$form["ACTION"]  = base_url()."index.php/form/edit/patient_exam/";
$form["ROW_ID"]="PATEXAMID";
$form["COLUMN_MODEL"] = array();
$form["ORIENT"] = "L";
$form["LIST"] = array( 'PATEXAMID');
$form["DISPLAY_LIST"] = array( 'ID');
//pager ends	
$form["FLD"]=array(

array(		
		"id"=>"ExamDate", 
		"name"=>"ExamDate",
		"label"=>"* Examination date",
		"type"=>"date",
		"value"=>date("Y-m-d"),
		"option"=>"",
		"placeholder"=>"Date of examination",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"onmousedown"=>"onmousedown=$('#ExamDate').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-40:c+40',dateFormat: 'yy-mm-dd',maxDate: '+0D'});"

	),	
array(		
		"id"=>"Weight", 
		"name"=>"Weight",
		"label"=>"Weight in Kg",
		"type"=>"number",
		"value"=>" ",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"Height", 
		"name"=>"Height",
		"label"=>"Height in m",
		"type"=>"number",
		"value"=>" ",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"sys_BP", 
		"name"=>"sys_BP",
		"label"=>"sys BP",
		"type"=>"text_default",
		"value"=>" ",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean|numeric",
		"style"=>"",
		"class"=>"input",
		"onmousedown"=>"onmousedown=$('#sys_BP').val(120);"
	),	
array(		
		"id"=>"diast_BP", 
		"name"=>"diast_BP",
		"label"=>"diast BP",
		"type"=>"text_default",
		"value"=>" ",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean|numeric",
		"style"=>"",
		"class"=>"input",
		"onmousedown"=>"onmousedown=$('#diast_BP').val(80);"
	),	
array(		
		"id"=>"Temprature", 
		"name"=>"Temprature",
		"label"=>"Temperature",
		"type"=>"text_default",
		"value"=>" ",
		"option"=>"",
		"placeholder"=>"Patient Temprature ",
		"rules"=>"trim|xss_clean|numeric",
		"style"=>"",
		"class"=>"input",
		"onmousedown"=>"onmousedown=$('#Temprature').val('36.6');"
	),		

array(		
		"id"=>"PID", 
		"name"=>"PID",
		"label"=>"",
		"type"=>"hidden",
		"value"=>$this->uri->segment(4),
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required|xss_clean",
		"class"=>"input",
		"style"=>""
	),
array(		
		"id"=>"Active", 
		"name"=>"Active",
		"label"=>"*Active",
		"type"=>"boolean",
		"value"=>"1",
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
			"value"=>"",
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