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
$form["OBJID"] = "UID";
$form["TABLE"] = "user";
$form["FORM_CAPTION"] = "User";
$form["SAVE"] = "user/save";
$form["NEXT"]  = "preference/load/user";
//pager starts
$form["CAPTION"]  = "Available user <input type=\'button\' class=\'btn btn-xs btn-success\' onclick=self.document.location=\'".site_url('form/create/user')."\' value=\'Add new\'>";
$form["ACTION"]  = base_url()."index.php/form/edit/user/";
$form["ROW_ID"]="UID";
$form["COLUMN_MODEL"] = array( 'UID'=>array("width"=>"35px"), 'FirstName', 'OtherName', 'DateOfBirth','Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')), 'Gender'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;Male:Male;Female:Female')),'Post','UserName','UserGroup','Address_Village');
$form["ORIENT"] = "L";
$form["LIST"] = array( 'UID', 'FirstName', 'OtherName', 'DateOfBirth','Active', 'Gender','Post','UserName','UserGroup','Address_Village');
$form["DISPLAY_LIST"] = array( 'Id', 'First name', 'Other name', 'Date of birth', 'Active','Gender','Post','User name','User group','Village');
//pager ends
$form["FLD"]=array(
array(		
		"id"=>"FirstName", 
		"name"=>"FirstName",
		"label"=>"*First Name",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"First Name",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"OtherName", 
		"name"=>"OtherName",
		"label"=>"Other Name",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Other Name",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"DateOfBirth", 
		"name"=>"DateOfBirth",
		"label"=>"Date Of Birth",
		"type"=>"date",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Date Of Birth",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"onmousedown"=>"onmousedown=$('#DateOfBirth').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-40:c+40',dateFormat: 'yy-mm-dd',maxDate: '+0D'});"

	),
	array(		
		"id"=>"Active", 
		"name"=>"Active",
		"label"=>"*Active",
		"type"=>"boolean",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Active",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Gender", 
		"name"=>"Gender",
		"label"=>"Gender",
		"type"=>"select",
		"value"=>"",
		"option"=>array("Male","Female"),
		"placeholder"=>"Gender",
		"rules"=>"",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Post", 
		"name"=>"Post",
		"label"=>"Post",
		"type"=>"table_select",
		"value"=>'',
		"option"=>"Post",
		"sql"=>"SELECT Name as Post 
		FROM user_post WHERE (Active = TRUE)  
		 ORDER BY Name ",
		"placeholder"=>"Post",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","")
	),

array(		
		"id"=>"UserName", 
		"name"=>"UserName",
		"label"=>"* User Name",
		"type"=>"text",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"User Name",
		"rules"=>"trim|xss_clean|required|is_unique[user.UserName]",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","")
	),
	
array(		
		"id"=>"Password", 
		"name"=>"Password",
		"label"=>"* Password",
		"type"=>"password",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Password"	,
		"rules"=>"trim|xss_clean|required",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","")
	),	
array(		
		"id"=>"UserGroup", 
		"name"=>"UserGroup",
		"label"=>"* User Group",
		"type"=>"table_select",
		"value"=>'',
		"option"=>"UserGroup",
		"sql"=>"SELECT Name as UserGroup 
		FROM user_group WHERE (Active = TRUE)  
		 ORDER BY Name ",
		"placeholder"=>"UserGroup",
		"rules"=>"trim|xss_clean|required",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","")
	),

array(		
		"id"=>"Address_Street", 
		"name"=>"Address_Street",
		"label"=>"Address ",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"eg. No32/2  ",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		
	),	
array(		
		"id"=>"Address_Village", 
		"name"=>"Address_Village",
		"label"=>"Village",
		"type"=>"village",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"Village",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
	
	array(		
		"id"=>"Address_DSDivision", 
		"name"=>"Address_DSDivision",
		"label"=>"",
		"type"=>"hidden",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"Address_District", 
		"name"=>"Address_District",
		"label"=>"",
		"type"=>"hidden",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	)
	);
//Address_Street	Address_Village	Address_DSDivision	Address_District
$patient["JS"] = "
<script>
function ForceSave(){
}
</script>
";  									
////////Configuration for patient form END;                   
?>