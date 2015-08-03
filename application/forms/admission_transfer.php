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
$form["OBJID"] = "ADTR";
$form["TABLE"] = "admission_transfer";
$form["SAVE"] = "admission/save_transfer";
$form["NEXT"]  = "admission/view";	// default page after saving 
$form["CONTINUE"]  = "";	//this can be filled when you want to coustomize what page to go after saving 
$form["PATIENT_BANNER_ID"] = "";
$form["FORM_CAPTION"] = "Ward tranfer";
//pager starts
$form["CAPTION"]  = "Transfer list";
$form["ACTION"]  = base_url()."index.php/form/edit/admission_transfer/";
$form["ROW_ID"]="ADTR";
$form["COLUMN_MODEL"] = array( 'ADTR'=>array("width"=>"35px"));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'ADTR', );
$form["DISPLAY_LIST"] = array( 'ID', );
//pager ends	
$form["FLD"]=array(
array(		
		"id"=>"TransferDate", 
		"name"=>"TransferDate",
		"label"=>"*Date trasfer",
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
		"id"=>"TransferFrom", 
		"name"=>"TransferFrom",
		"label"=>"*Transfer from",
		"type"=>"label",
		"value"=>urlencode($this->uri->segment(5)),
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		
	),
array(		
		"id"=>"TransferTo", 
		"name"=>"TransferTo",
		"label"=>"*Transfer to",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'TransferTo',
		"option"=>'WID',
		"sql"=>"SELECT WID ,Name  as TransferTo 
		FROM ward WHERE (Active = TRUE)
		 ORDER BY Name ",
		"placeholder"=>"Ward",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"edit_access"=>array("","Admin")
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