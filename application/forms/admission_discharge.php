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


////////Configuration for admission form
$form = array();
$form["OBJID"] = "ADMID";
$form["TABLE"] = "admission";
$form["SAVE"] = "admission/discharge";
$form["NEXT"]  = "admission/view";	// default page after saving 
$form["CONTINUE"]  = "";	//this can be filled when you want to coustomize what page to go after saving 
$form["PATIENT_BANNER_ID"] = "";
$form["FORM_CAPTION"] = "Discharge";
//pager starts
$form["CAPTION"]  = "Admission list";
$form["ACTION"]  = base_url()."index.php/form/edit/ward/";
$form["ROW_ID"]="ADMID";
$form["COLUMN_MODEL"] = array( 'ADMID'=>array("width"=>"35px"));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'ADMID', );
$form["DISPLAY_LIST"] = array( 'ID', );
//pager ends	
$form["FLD"]=array(
array(		
		"id"=>"AdmissionDate", 
		"name"=>"AdmissionDate",
		"label"=>"*Date and time of admission",
		"type"=>"timestamp",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"DischargeDate", 
		"name"=>"DischargeDate",
		"label"=>"*Date and time of discharge",
		"type"=>"date",
		"value"=>date("Y-m-d"),
		"option"=>"",
		"placeholder"=>"Onset date",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"onmousedown"=>"onmousedown=$('#DischargeDate').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-40:c+40',dateFormat: 'yy-mm-dd',maxDate: '+0D'});"
	),

array(		
		"id"=>"Discharge_Doctor", 
		"name"=>"Discharge_Doctor",
		"label"=>"* Discharging doctor ",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'UID',
		"sql"=>"SELECT UID,CONCAT(Title,FirstName,' ',OtherName ) as Discharge_Doctor 
		FROM user WHERE (Active = TRUE) AND ((Post = 'OPD Doctor') OR (Post = 'Consultant')) 
		 ORDER BY OtherName ",
		"placeholder"=>"Doctor",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"OutCome", 
		"name"=>"OutCome",
		"label"=>"*Out Come",
		"type"=>"select",
		"value"=>'',
		"option"=>array("Discharged recovered","Discharged to be followed up","Died"),
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