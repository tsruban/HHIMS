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
$form["OBJID"] = "HID";
$form["TABLE"] = "hospital";
$form["FORM_CAPTION"] = "Hospital";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/hospital";
//pager starts
$form["CAPTION"]  = "Hospital ";
//
$form["ACTION"]  = base_url()."index.php/form/edit/hospital/";
$form["ROW_ID"]="HID";
$form["COLUMN_MODEL"] = array( 'HID'=>array("width"=>"35px"), 'Name','Code','Type', 'Address_Village', 'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'HID', 'Name','Code','Type', 'Address_Village', 'Active');
$form["DISPLAY_LIST"] = array( 'Id', 'Name','Code','Type', 'Address Village', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"Name", 
		"name"=>"Name",
		"label"=>"*Name",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Name",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","")
	),
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
		"class"=>"input",
		"can_edit"=>array("","")
	),
array(		
		"id"=>"Type", 
		"name"=>"Type",
		"label"=>"*Type",
		"type"=>"select",
		"value"=>"",
		"option"=>array("PBH"),
		"placeholder"=>"Complaint Type",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","")
	),	
array(		
		"id"=>"Address_Street", 
		"name"=>"Address_Street",
		"label"=>"Address ",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"eg. No32/2  ",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		
	),	
array(		
		"id"=>"Address_Village", 
		"name"=>"Address_Village",
		"label"=>"Village",
		"type"=>"village",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Village",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
	array(		
		"id"=>"Address_DSDivision", 
		"name"=>"Address_DSDivision",
		"label"=>"",
		"type"=>"hidden",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"Address_District", 
		"name"=>"Address_District",
		"label"=>"",
		"type"=>"hidden",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Visit_SNOMED_Field", 
		"name"=>"Visit_SNOMED_Field",
		"label"=>"Add SNOMED field in visit",
		"type"=>"boolean",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"Visit_ICD_Field", 
		"name"=>"Visit_ICD_Field",
		"label"=>"Add ICD field in visit",
		"type"=>"boolean",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"occupation_field", 
		"name"=>"occupation_field",
		"label"=>"Add occupation field in patient reg.",
		"type"=>"boolean",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),		
array(		
		"id"=>"Token_Footer_Text", 
		"name"=>"Token_Footer_Text",
		"label"=>"Token footer note",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","")
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