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
$form["OBJID"] = "DDSGID";
$form["TABLE"] = "drugs_dosage";
$form["FORM_CAPTION"] = "Drugs Dosage";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/drugs_dosage";	
//pager starts
$form["CAPTION"]  = "Drugs dosage <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/drugs_dosage')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/drugs_dosage/";
$form["ROW_ID"]="DDSGID";
$form["COLUMN_MODEL"] = array( 'DDSGID'=>array("width"=>"35px"), 'Dosage', 'Type', 'Factor', 'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'DDSGID', 'Dosage', 'Type', 'Factor', 'Active');
$form["DISPLAY_LIST"] = array( 'ID', 'Dosage', 'Type', 'Factor', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"Dosage", 
		"name"=>"Dosage",
		"label"=>"*Dosage",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Dosage",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Type", 
		"name"=>"Type",
		"label"=>"*Type",
		"type"=>"select",
		"value"=>"",
		"option"=>array("Tablet","Liquid","Multidose","Other"),
		"placeholder"=>"Complaint Type",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"Factor", 
		"name"=>"Factor",
		"label"=>"Factor",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Factor",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Active", 
		"name"=>"Active",
		"label"=>"*Active",
		"type"=>"boolean",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required",
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