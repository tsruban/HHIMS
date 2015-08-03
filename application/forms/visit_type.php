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
$form["OBJID"] = "VTYPID";
$form["TABLE"] = "visit_type";
$form["FORM_CAPTION"] = "Visit Type";
$form["SAVE"] = "";
$form["NEXT"]  = "preference/load/visit_type";
//pager starts
$form["CAPTION"]  = "Visit Type <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/visit_type')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/visit_type/";
$form["ROW_ID"]="VTYPID";
$form["COLUMN_MODEL"] = array( 'VTYPID'=>array("width"=>"35px"), 'Name','Remarks','Stock', 'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'VTYPID', 'Name','Remarks','Stock', 'Active');
$form["DISPLAY_LIST"] = array( 'Id', 'Name','Remarks','Pharmacy stock', 'Active');

//pager ends
if ($this->config->item('purpose') !="PP"){
		$stock_sql= "SELECT drug_stock_id,name as Stock FROM drug_stock WHERE Active = TRUE ORDER BY name ";	
		$config="";
}else{
	$config="PP";
	$stock_sql="SELECT drug_stock_id,name as Stock FROM drug_stock WHERE Active = TRUE AND name = 'OPD' ORDER BY name ";	
}

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
		"id"=>"Stock", 
		"name"=>"Stock",
		"label"=>"*Pharmacy stock ",
		"type"=>"table_select",
		"value"=>"set_select('Stock', 'OPD', TRUE);",
		"option"=>'drug_stock_id',	
		"sql"=>"$stock_sql",
		"placeholder"=>"",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","Admin"),
		"config"=>"$config"
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