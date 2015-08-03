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


////////Configuration for treatment form
$form = array();
$form["OBJID"] = "TREATMENTID";
$form["TABLE"] = "treatment";
$form["FORM_CAPTION"] = "Treatment";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/treatment";	
//pager starts
$form["CAPTION"]  = "Treatment <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/treatment')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/treatment/";
$form["ROW_ID"]="TREATMENTID";
$form["COLUMN_MODEL"] = array( 'TREATMENTID'=>array("width"=>"35px"), 'Treatment', 'Type', 'Remarks', 'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'TREATMENTID', 'Treatment', 'Type', 'Remarks', 'Active');
$form["DISPLAY_LIST"] = array( 'TREATMENTID', 'Treatment', 'Type', 'Remarks', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"Treatment", 
		"name"=>"Treatment",
		"label"=>"*Treatment name",
		"type"=>"remarks",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Treatment",
		"rules"=>"xss_clean|required",
		"class"=>"input",
		"style"=>"",
		"rows"=>"2",
		"cols"=>"300"
	),	
array(		
		"id"=>"Type", 
		"name"=>"Type",
		"label"=>"*Treatment Type",
		"type"=>"select",
		"value"=>"",
		"option"=>array("OPD","ADM"),
		"placeholder"=>"Treatment Type",
		"rules"=>"required",
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
		"rows"=>"3",
		"cols"=>"300"
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