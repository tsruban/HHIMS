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
$form["OBJID"] = "PRMID";
$form["TABLE"] = "permission";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/permission";	
//pager starts
$form["CAPTION"]  = "Permission Allocation";
$form["ACTION"]  = base_url()."index.php/form/edit/permission/";
$form["ROW_ID"]="PRMID";
$form["COLUMN_MODEL"] = array( 'PRMID'=>array("width"=>"35px"), 'UserGroup','Remarks');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'PRMID', 'UserGroup','Remarks');
$form["DISPLAY_LIST"] = array( 'Id', 'User Group','Remarks');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"UserGroup", 
		"name"=>"UserGroup",
		"label"=>"*User Group",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"User Group",
		"rules"=>"trim|required|xss_clean",
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