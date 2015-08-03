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
$form["OBJID"] = "UGID";
$form["TABLE"] = "user_group";
$form["FORM_CAPTION"] = "User Group";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/user_group";
//pager starts
$form["CAPTION"]  = "User Group <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/user_group')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/user_group/";
$form["ROW_ID"]="UGID";
$form["COLUMN_MODEL"] = array( 'UGID'=>array("width"=>"35px"), 'Name', 'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')),'Remarks','MainMenu','Scan_Redirect');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'UGID', 'Name', 'Active','Remarks','MainMenu','Scan_Redirect');
$form["DISPLAY_LIST"] = array( 'Id', 'Name', 'Active','Remarks','Main Menu','Scan Redirect');
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
		"id"=>"Active", 
		"name"=>"Active",
		"label"=>"Active",
		"type"=>"boolean",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Active",
		"rules"=>"trim|xss_clean",
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
	),
array(		
		"id"=>"MainMenu", 
		"name"=>"MainMenu",
		"label"=>"Main Menu",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Main Menu",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Scan_Redirect", 
		"name"=>"Scan_Redirect",
		"label"=>"Scan Redirect",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Scan Redirect",
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