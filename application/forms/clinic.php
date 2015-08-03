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
$form["OBJID"] = "clinic_id";
$form["TABLE"] = "clinic";
$form["FORM_CAPTION"] = "Hospital clinics";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/clinic";
//pager starts
$form["CAPTION"]  = "Visit Type <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/clinic')."\' value=\'Add new Clinic\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/clinic/";
$form["ROW_ID"]="clinic_id";
$form["COLUMN_MODEL"] = array( 'clinic_id'=>array("width"=>"35px"), 'name','applicable_to','Remarks','Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'clinic_id', 'Name','applicable_to', 'remarks', 'Active');
$form["DISPLAY_LIST"] = array( 'Id', 'Name','Applicable to','Remarks', 'Active');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"name", 
		"name"=>"name",
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
		"id"=>"remarks", 
		"name"=>"remarks",
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
		"id"=>"drug_stock", 
		"name"=>"drug_stock",
		"label"=>"*Pharmacy stock ",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'drug_stock_id',
		"sql"=>"SELECT drug_stock_id as drug_stock_id,name as drug_stock FROM drug_stock WHERE Active = TRUE 
		 ORDER BY name " ,
		"placeholder"=>"",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","Admin")
	),
array(		
		"id"=>"applicable_to", 
		"name"=>"applicable_to",
		"label"=>"*Applicable to",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("Male","Female","Both"),
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