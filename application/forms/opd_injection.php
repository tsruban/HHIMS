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


////////Configuration for opd_treatment form
$form = array();
$form["OBJID"] = "patient_injection_id";
$form["TABLE"] = "opd_injection";
$form["SAVE"] = "";
$form["SAVE_TABLE"] = "patient_injection";
$form["NEXT"]  = "opd/view";	// default page after saving 
$form["CONTINUE"]  = "";	//this can be filled when you want to coustomize what page to go after saving 
$form["PATIENT_BANNER_ID"] = $this->uri->segment(4);
$form["FORM_CAPTION"] = "OPD Patient injection order";
//pager starts
$form["CAPTION"]  = "Patient OPD injection order";
$form["ACTION"]  = base_url()."index.php/form/edit/patient_injection/";
$form["ROW_ID"]="patient_injection_id";
$form["COLUMN_MODEL"] = array();
$form["ORIENT"] = "L";
$form["LIST"] = array( 'patient_injection_id');
$form["DISPLAY_LIST"] = array( 'ID');
$form["LEFT_BAR"][0] = array('title'=>'Previous Injections','id'=>'Previous_injection','run_function'=>"patient/get_previous_injection_list",'param'=>$this->uri->segment(4));

//pager ends	
$form["FLD"]=array(

array(		
		"id"=>"injection_id", 
		"name"=>"injection_id",
		"label"=>"* Injection",
		"type"=>"table_select",
		"value"=>"",
		"option"=>"iid",
		"sql"=>"SELECT concat(injection.name,'  -  ',injection.dosage,'  -  ',injection.route) as injection_id, injection.injection_id  as iid FROM injection WHERE Active = TRUE 
		 ORDER BY name " ,
		"placeholder"=>"Treatment",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input"
	),	
	
array(		
		"id"=>"status", 
		"name"=>"status",
		"label"=>"",
		"type"=>"hidden",
		"value"=>"Pending",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"xss_clean",
		"class"=>"input",
		"style"=>"",
		"rows"=>"2",
		"cols"=>"300"
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
		"rows"=>"2",
		"cols"=>"300"
	),
array(		
		"id"=>"episode_type", 
		"name"=>"episode_type",
		"label"=>"",
		"type"=>"hidden",
		"value"=>"OPD",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"xss_clean",
		"class"=>"input",
		"style"=>"",
		"rows"=>"2",
		"cols"=>"300"
	),
array(		
		"id"=>"episode_id", 
		"name"=>"episode_id",
		"label"=>"",
		"type"=>"hidden",
		"value"=>$this->uri->segment(5),
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required|xss_clean",
		"class"=>"input",
		"style"=>""
	),
array(		
		"id"=>"order_by_id", 
		"name"=>"order_by_id",
		"label"=>"",
		"type"=>"hidden",
		"value"=>$this->session->userdata("UID"),
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required|xss_clean",
		"class"=>"input",
		"style"=>""
	),
array(		
		"id"=>"PID", 
		"name"=>"PID",
		"label"=>"",
		"type"=>"hidden",
		"value"=>$this->uri->segment(4),
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required|xss_clean",
		"class"=>"input",
		"style"=>""
	),
array(		
		"id"=>"Active", 
		"name"=>"Active",
		"label"=>"*Active",
		"type"=>"boolean",
		"value"=>"1",
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required|xss_clean",
		"class"=>"input",
		"style"=>""
	)
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
			"value"=>"opd/view/".$this->uri->segment(4),
			"option"=>"",
			"placeholder"=>"",
			"rules"=>"xss_clean",
			"class"=>"input",
			"style"=>""
		)
	);
}
$patient["JS"] = "
<script>
function ForceSave(){
}
</script>
";  									
////////Configuration for patient form END;                   
?>