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
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/


////////Configuration for treatment form
$form = array();
$form["OBJID"] = "injection_id";
$form["TABLE"] = "injection";
$form["FORM_CAPTION"] = "Injection";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/injection";	
//pager starts
$form["CAPTION"]  = "Injection <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/injection')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/injection/";
$form["ROW_ID"]="injection_id";
$form["COLUMN_MODEL"] = array('injection_id'=>array("width"=>"55px"), 'name', 'dosage','route', 'remarks', 
'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'injection_id', 'Name','Dosage','Route', 'Remarks', 'Active');
$form["DISPLAY_LIST"] = array( 'injection_id', 'Name', 'Dosage','Route', 'Remarks', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"name", 
		"name"=>"name",
		"label"=>"*Injection name",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Injection name",
		"rules"=>"xss_clean|required",
		"class"=>"input",
		"style"=>"",
		"rows"=>"2",
		"cols"=>"300"
	),	
array(		
		"id"=>"dosage", 
		"name"=>"dosage",
		"label"=>"*Injection dosage",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Dosage",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"route", 
		"name"=>"route",
		"label"=>"Injection route",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"route",
		"rules"=>"xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"remarks", 
		"name"=>"remarks",
		"label"=>"remarks",
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
		"value"=>"1",
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