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


////////Configuration for opd_visits form
$form = array();
$form["OBJID"] = "NOTIFICATION_ID";
$form["TABLE"] = "notification";
$form["SAVE"] = "";
$form["NEXT"]  = "";	// default page after saving 
$form["CONTINUE"]  = "";	//this can be filled when you want to coustomize what page to go after saving 
$form["PATIENT_BANNER_ID"] = $this->uri->segment(5);

$form["FORM_CAPTION"] = "OPD visit";

$form["FLD"]=array(
array(		
		"id"=>"CreateDate", 
		"name"=>"CreateDate",
		"label"=>"*Creation date",
		"type"=>"timestamp",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"Episode_Type", 
		"name"=>"Episode_Type",
		"label"=>"* Type",
		"type"=>"label",
		"value"=>$this->uri->segment(4),
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"edit_access"=>array("Programmer","Admin"),	),	

	);
$form["ADDITIONAL_BUTTONS_CONTINUE"] = "opd/view";	
$form["ADDITIONAL_BUTTONS"]=array(
	array("value"=>"Treatment","name"=>"saveoption","id"=>"next1","next1"=>"form/create/opd_treatment"),
	array("value"=>"Prescription","name"=>"saveoption","id"=>"next2","next2"=>"opd/new_prescribe"),
	array("value"=>"Lab order","name"=>"saveoption","id"=>"next6","next6"=>"laboratory/opd_order"),
	array("value"=>"History","name"=>"saveoption","id"=>"next3","next3"=>"form/create/patient_history/".$this->uri->segment(4)),
	array("value"=>"Allergies","name"=>"saveoption","id"=>"next4","next4"=>"form/create/patient_alergy/".$this->uri->segment(4)),
	array("value"=>"Examination","name"=>"saveoption","id"=>"next5","next5"=>"form/create/patient_exam/".$this->uri->segment(4)),
);
$patient["JS"] = "
<script>
function ForceSave(){
}
</script>
";  									
////////Configuration for patient form END;                   
?>