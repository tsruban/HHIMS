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
$form["OBJID"] = "INSTID";
$form["TABLE"] = "institution";
$form["FORM_CAPTION"] = "Institution";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/institution";	
//pager starts
$form["CAPTION"]  = "Institution <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/institution')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/institution/";
$form["ROW_ID"]="INSTID";
$form["COLUMN_MODEL"] = array( 'INSTID'=>array("width"=>"35px"), 'Name','Type','Email1', 'Telephone1', 'Address_Village', 'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'INSTID', 'Name','Type','Email1', 'Telephone1', 'Address_Village', 'Active');
$form["DISPLAY_LIST"] = array( 'Id', 'Name','Type','Email1', 'Telephone', 'Address Village', 'Active');
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
		"class"=>"input"
	),
array(		
		"id"=>"Type", 
		"name"=>"Type",
		"label"=>"*Type",
		"type"=>"select",
		"value"=>"",
		"option"=>array("Type"),
		"placeholder"=>"Complaint Type",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"Email1", 
		"name"=>"Email1",
		"label"=>"Email",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Email",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Telephone1", 
		"name"=>"Telephone1",
		"label"=>"Telephone",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Telephone",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Address_Village", 
		"name"=>"Address_Village",
		"label"=>"Address Village",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Address Village",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Active", 
		"name"=>"Active",
		"label"=>"Active",
		"type"=>"boolean",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"",
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