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
$form["OBJID"] = "PID";
$form["TABLE"] = "patient";
$form["SAVE"] = "patient/save";
$form["CONTINUE"]  = "patient/view";
$form["FORM_CAPTION"] = "Pain clinic patient registration";
$form["NEXT"]  = "patient/view";
$form["FLD"]=array(
array(		
		"id"=>"Personal_Title", 
		"name"=>"Personal_Title",
		"label"=>"Title",
		"type"=>"select",
		"value"=>'.set_value($form["FLD"][$i]["name"]).',
		"option"=>array("Mr.","Ms.","Mrs.","Rev.","Dr.","Prof.","Hon.","Baby."),
		"placeholder"=>"Patient's title Mr./Dr./Mrs./Mrs./Prof./Ref.",
		"rules"=>"",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Admin")
	),
array(		
		"id"=>"Full_Name_Registered", 
		"name"=>"Full_Name_Registered",
		"label"=>"*Name",
		"type"=>"text",
		"value"=>"",
		"option"=>" ",
		"placeholder"=>"Name of the patient",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","Admin")
	),	
array(		
		"id"=>"Personal_Used_Name", 
		"name"=>"Personal_Used_Name",
		"label"=>"Other Name/Initials",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Initials of the patient",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","Admin")
	),
array(		
		"id"=>"Gender", 
		"name"=>"Gender",
		"label"=>"*Gender",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("Male","Female"),
		"placeholder"=>"Gender of the patient",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","Admin")
	),
array(		
		"id"=>"Personal_Civil_Status", 
		"name"=>"Personal_Civil_Status",
		"label"=>"Civil Status",
		"type"=>"select",
		"value"=>" ",
		"option"=>array("Single","Married","Divorced","Widow","UnKnown"),
		"placeholder"=>"Civil status of the patient.",
		"rules"=>"",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","Admin")
	),
array(		
		"id"=>"Age", 
		"name"=>"Age",
		"label"=>"Age of patient",
		"type"=>"age",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"numeric|xss_clean",
		"class"=>"input",
		"style"=>"width:10%"
	),	
array(		
		"id"=>"DateOfBirth", 
		"name"=>"DateOfBirth",
		"label"=>"Date of birth",
		"type"=>"date",
		"value"=>NULL,
		"option"=>"age",
		"placeholder"=>"Patient's date of birth.",
		"rules"=>"xss_clean",
		"style"=>"",
		"class"=>"input",
		"onmousedown"=>"onmousedown=$('#DateOfBirth').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-40:c+40',dateFormat: 'yy-mm-dd',maxDate: '+0D'});"
	),	



array(		
		"id"=>"NIC", 
		"name"=>"NIC",
		"label"=>"National ID",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"762727263v",
		"rules"=>"exact_length[10]|xss_clean|callback_nic_check",
		"style"=>"",
		"class"=>"input"
	),		
array(		
		"id"=>"occupation", 
		"name"=>"occupation",
		"label"=>"Occupation",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Driver ",
		"rules"=>"xss_clean",
		"style"=>"",
		"class"=>"input"
	),		
array(		
		"id"=>"Telephone", 
		"name"=>"Telephone",
		"label"=>"Contact Telephone",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Contact Telephone Number",
		"rules"=>"trim|numeric|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
array(		
		"id"=>"Address_Street", 
		"name"=>"Address_Street",
		"label"=>"Address 1",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"eg. No32/2  ",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","Admin")
	),	
array(		
		"id"=>"Address_Street1", 
		"name"=>"Address_Street1",
		"label"=>"Address 2",
		"type"=>"text",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Lake Road",
		"rules"=>"trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","Admin")
	),	
array(		
		"id"=>"Address_Village", 
		"name"=>"Address_Village",
		"label"=>"*Village",
		"type"=>"village",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Birth address: eg. Navatkudah",
		"rules"=>"required",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("","Admin")
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
	),		
array(		
		"id"=>"Remarks", 
		"name"=>"Remarks",
		"label"=>"Remarks",
		"type"=>"remarks",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"Any remarks",
		"rules"=>"trim|xss_clean",
		"class"=>"input",
		"style"=>"margin-left: 0px; margin-right: 0px; width: 389px; ",
		"rows"=>"3",
		"cols"=>"300"
	),		
array(		
		"id"=>"LPID", 
		"name"=>"LPID",
		"label"=>"",
		"type"=>"hidden",
		"value"=>"",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|xss_clean|numeric",
		"class"=>"",
		"style"=>""
	),		
	);
if (isset($_GET["CONTINUE"])){
array_push ($form["FLD"],
	array(		
			"id"=>"CONTINUE", 
			"name"=>"CONTINUE",
			"label"=>"",
			"type"=>"hidden",
			"value"=>$_GET["CONTINUE"],
			"option"=>"",
			"placeholder"=>"",
			"rules"=>"xss_clean",
			"class"=>"input",
			"style"=>""
		)
	);
}
else{
array_push ($form["FLD"],
	array(		
			"id"=>"CONTINUE", 
			"name"=>"CONTINUE",
			"label"=>"",
			"type"=>"hidden",
			"value"=>"",
			"option"=>"",
			"placeholder"=>"",
			"rules"=>"xss_clean",
			"class"=>"input",
			"style"=>""
		)
	);
}
	/*

  
   

     
    $form["FLD"][14]=array(
                                    "Id"=>"Address_DSDivision", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>"","valid"=>""
                                    );    
      $form["FLD"][15]=array(
                                    "Id"=>"Address_District", "Name"=>"",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>"","valid"=>""
                                    );       
      $form["FLD"][16]=array(
                                    "Id"=>"PID", "Name"=>"PID",   "Type"=>"hidden",     "Value"=>"",     "Help"=>"",   "Ops"=>"","valid"=>""
                                    );   
		      $form["FLD"][17]=array(
                                    "Id"=>"FS", "Name"=>"FS",   "Type"=>"hidden",     "Value"=>"0",     "Help"=>"",   "Ops"=>"","valid"=>""
                                    );   						
$form["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
   
*/
$patient["JS"] = "
<script>
function ForceSave(){
}
</script>
";  									
////////Configuration for patient form END;                   
?>