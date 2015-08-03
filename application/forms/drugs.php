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
$form["OBJID"] = "DRGID";
$form["TABLE"] = "drugs";
$form["FORM_CAPTION"] = "Drugs";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/drugs";	
//pager starts
$form["CAPTION"]  = "Drugs <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/drugs')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/drugs/";
$form["ROW_ID"]="DRGID";
$form["COLUMN_MODEL"] = array( 'DRGID'=>array("width"=>"35px"), 'Name', 'Type', 'dDosage', 'dFrequency', 'Stock', 'ClinicStock', 'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'DRGID', 'Name', 'Type', 'dDosage', 'dFrequency', 'Stock', 'ClinicStock', 'Active');
$form["DISPLAY_LIST"] = array( 'DRGID', 'Drug Name', 'Type', 'Dosage', 'Frequency', 'Stock', 'Clinic Stock', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"Name", 
		"name"=>"Name",
		"label"=>"*Drug Name",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"complaints",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Stock", 
		"name"=>"Stock",
		"label"=>"*OPD Stock",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"OPD Stock",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"ClinicStock", 
		"name"=>"ClinicStock",
		"label"=>"*Clinic Stock",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Clinic Stock",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Type", 
		"name"=>"Type",
		"label"=>"Drug Type",
		"type"=>"select",
		"value"=>"",
		"option"=>array("Tablet","Liquid","Multidose","Other"),
		"placeholder"=>"Drug Type",
		"rules"=>"",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"dDosage", 
		"name"=>"dDosage",
		"label"=>"Defailt Dosage",
		"type"=>"select",
		"value"=>"",
		"option"=>array("1/2","1","1/4","1/3","2/3","2","3","1 1/2","4","77","Maji"),
		"placeholder"=>"Defailt Dosage",
		"rules"=>"",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"dFrequency", 
		"name"=>"dFrequency",
		"label"=>"Defailt Frequency",
		"type"=>"select",
		"value"=>"",
		"option"=>array("Once a day","bd","tds","qds","nocte","stat","amila","Two times per day"),
		"placeholder"=>"Defailt Frequency",
		"rules"=>"",
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
		"rows"=>"2",
		"cols"=>"300"
	)	,	
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