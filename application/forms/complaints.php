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

////////Configuration for patient form
$form = array();
$form["OBJID"] = "COMPID";
// $form["TABLE"] will be used in SQL query
$form["TABLE"] = "complaints";
$form["FORM_CAPTION"] = "Complaints";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/complaints";	
//pager starts
$form["CAPTION"]  = ""/*"Complaints <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/complaints')."\' value=\'Add new\'>"*/;
$form["ACTION"]  = base_url()."index.php/form/edit/complaints/";
$form["ROW_ID"]="COMPID";
//add ICPC Name and code
$form["COLUMN_MODEL"] = array( 'COMPID'=>array("width"=>"55px"), 'ICPCCode','Name'=>array("width"=>"250px"),'ICDCode',
 'Remarks', 'isNotify'=>array("width"=>"5px"), 'Active'); 	
$form["ORIENT"] = "L";
// $form["LIST"] will be used in SQL query
$form["LIST"] = array( 'COMPID', 'ICPCCode', 'Name','ICDCode',  'Remarks', 'isNotify', 'Active');

$form["DISPLAY_LIST"] = array( 'COMPID', 'ICPCCode', 'Name','ICDCode',  'Remarks', 'isNotify', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"ICPCCode", 
		"name"=>"ICPCCode",
		"label"=>"ICPC Code",
		"type"=>"remarks",
		"value"=>" ",
		"option"=>" ",
		"placeholder"=>"ICPC Code",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Name", 
		"name"=>"Name",
		"label"=>"*ICPC complaint",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"complaints",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
	array(		
		"id"=>"ICDCode", 
		"name"=>"ICDCode",
		"label"=>"ICD Code",
		"type"=>"remarks",
		"value"=>" ",
		"option"=>" ",
		"placeholder"=>"ICD Code",
		"rules"=>"trim|xss_clean",
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
		"id"=>"isNotify", 
		"name"=>"isNotify",
		"label"=>"*is Notify",
		"type"=>"boolean",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required",
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
		"placeholder"=>"Active",
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