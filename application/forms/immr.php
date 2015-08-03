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
$form["OBJID"] = "IMMRID";
$form["TABLE"] = "immr";
$form["FORM_CAPTION"] = "IMMR";
$form["SAVE"] = "";

$form["NEXT"]  = "preference/load/immr";	
//pager starts
$form["CAPTION"]  = "IMMR <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/immr')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/immr/";
$form["ROW_ID"]="IMMRID";
$form["COLUMN_MODEL"] = array( 'IMMRID'=>array("width"=>"35px"), 'Code', 'Name', 'Category', 'ICDCODE');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'IMMRID', 'Code', 'Name', 'Category', 'ICDCODE');
$form["DISPLAY_LIST"] = array( 'IMMRID', 'IMMR Code', 'IMMR Name', 'Category', 'ICD Code');
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
		"id"=>"Category", 
		"name"=>"Category",
		"label"=>"*Category",
		"type"=>"remarks",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Category",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"ICDCODE", 
		"name"=>"ICDCODE",
		"label"=>"ICDCODE",
		"type"=>"remarks",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"ICDCODE",
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