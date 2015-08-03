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


////////Configuration for patient form
$form = array();
$form["OBJID"] = "ICDID";
$form["TABLE"] = "icd10";
$form["FORM_CAPTION"] = "ICD 10";
$form["SAVE"] = "";

$form["NEXT"]  = "preference/load/icd10";	
//pager starts
$form["CAPTION"]  = "ICD 10 <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/icd10')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/icd10/";
$form["ROW_ID"]="ICDID";
$form["COLUMN_MODEL"] = array( 'ICDID'=>array("width"=>"35px"), 'Code', 'Name', 'isNotify', 'Remarks');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'ICDID', 'Code', 'Name', 'isNotify', 'Remarks');
$form["DISPLAY_LIST"] = array( 'ICDID', 'ICD Code', 'ICD Name', 'isNotify', 'Remarks');


//pager ends
$form["FLD"]=array(
array(		
		"id"=>"Code", 
		"name"=>"Code",
		"label"=>"*Code",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Code",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Name", 
		"name"=>"Name",
		"label"=>"*Name",
		"type"=>"remarks",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Name",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"isNotify", 
		"name"=>"isNotify",
		"label"=>"*is Notifiable",
		"type"=>"boolean",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"isNotify",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Remarks", 
		"name"=>"Remarks",
		"label"=>"Remarks",
		"type"=>"remarks",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Remarks",
		"rules"=>"trim|xss_clean",
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