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
$form["OBJID"] = "DISORDERID";
$form["TABLE"] = "disorder";
$form["FORM_CAPTION"] = "SNOMED Disorder";
$form["SAVE"] = "";

$form["NEXT"]  = "preference/load/disorder";	
//pager starts
$form["CAPTION"]  = "SNOMED Disorder ";
$form["ACTION"]  = base_url()."index.php/form/edit/disorder/";
$form["ROW_ID"]="DISORDERID";
$form["COLUMN_MODEL"] = array( 'DISORDERID'=>array("width"=>"35px"), 'CONCEPTID', 'TERM', 'CONCEPTID', 'TERM');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'DISORDERID', 'CONCEPTID', 'TERM', 'Link_ICD_Code', 'Link_ICD_Text');
$form["DISPLAY_LIST"] = array( 'ID', 'CONCEPTID', 'TERM', 'ICD CODE', 'ICD TEXT');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"CONCEPTID", 
		"name"=>"CONCEPTID",
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
		"id"=>"TERM", 
		"name"=>"TERM",
		"label"=>"*Term",
		"type"=>"remarks",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Term",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"INITIALCAPITALSTATUS", 
		"name"=>"INITIALCAPITALSTATUS",
		"label"=>"*Status",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Status",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Active", 
		"name"=>"Active",
		"label"=>"Active",
		"type"=>"boolean",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Active",
		"rules"=>"trim|required|xss_clean",
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