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
//print_r($data['hospital']["Visit_ICD_Field"]);
//exit;
$form = array();
$form["OBJID"] = "OPDID";
$form["TABLE"] = "opd_visits";
$form["SAVE"] = "";
$form["NEXT"]  = "opd/view";	// default page after saving 
$form["CONTINUE"]  = "";	//this can be filled when you want to coustomize what page to go after saving 
$form["PATIENT_BANNER_ID"] = $this->uri->segment(4);

$form["FORM_CAPTION"] = "OPD visit";
//pager starts
$form["CAPTION"]  = "OPD visit list";
$form["ACTION"]  = base_url()."index.php/form/edit/ward/";
$form["ROW_ID"]="WID";
$form["COLUMN_MODEL"] = array( 'WID'=>array("width"=>"35px"), 'Name', 'Type', 'Telephone', 'BedCount', 'Remarks', 'Active'=> array('stype' => 'select', 'editoptions' => array('value' => ':All;1:Yes;0:No')));
$form["ORIENT"] = "L";
$form["LIST"] = array( 'WID', 'Name', 'Type', 'Telephone', 'BedCount', 'Remarks', 'Active');
$form["DISPLAY_LIST"] = array( 'ID', 'Name', 'Type', 'Telephone', 'BedCount', 'Remarks', 'Active');
//pager ends	
$form["FLD"]=array(
array(		
		"id"=>"DateTimeOfVisit", 
		"name"=>"DateTimeOfVisit",
		"label"=>"*Date and time of visit",
		"type"=>"timestamp",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input"
	),
array(		
		"id"=>"OnSetDate", 
		"name"=>"OnSetDate",
		"label"=>"* Onset Date",
		"type"=>"date",
		"value"=>date("Y-m-d"),
		"option"=>"",
		"placeholder"=>"Onset date",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"edit_access"=>array("Programmer","Admin"),
		"onmousedown"=>"onmousedown=$('#OnSetDate').datepicker({changeMonth: true,changeYear: true,yearRange: 'c-40:c+40',dateFormat: 'yy-mm-dd',maxDate: '+0D'});"
	),	
array(		
		"id"=>"Doctor", 
		"name"=>"Doctor",
		"label"=>"*Doctor ",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'UID',
		"sql"=>"SELECT UID,CONCAT(Title,FirstName,' ',OtherName ) as Doctor 
		FROM user WHERE (Active = TRUE) AND ((Post = 'OPD Doctor') OR (Post = 'Consultant')) 
		 ORDER BY OtherName ",
		"placeholder"=>"Doctor",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","Admin")
	),	
array(		
		"id"=>"VisitType", 
		"name"=>"VisitType",
		"label"=>"*Visit type ",
		"type"=>"table_select",
		"value"=>'',
		"option"=>'VTYPID',
		"sql"=>"SELECT VTYPID,Name as VisitType FROM visit_type WHERE Active = TRUE 
		 ORDER BY Name " ,
		"placeholder"=>"Visit Type",
		"rules"=>"required|trim|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","Admin")
	),		
array(		
		"id"=>"Complaint", 
		"name"=>"Complaint",
		"label"=>"*Complaint / Injury",
		"type"=>"complaint_lookup",
		"value"=>'',
		"option"=>"",
		"placeholder"=>"complaint",
		"rules"=>"trim|required|xss_clean",
		"style"=>"",
		"class"=>"input",
		"can_edit"=>array("Programmer","Admin")
	)
);
// not PP config	
if ($this->config->item('purpose') != "PP"){	
if(isset($data['hospital']["Visit_ICD_Field"])&&( $data['hospital']["Visit_ICD_Field"]==1)){
	array_push($form["FLD"],array(		
			"id"=>"ICD_Text", 
			"name"=>"ICD_Text",
			"label"=>"ICD",
			"type"=>"icd_lookup",
			"value"=>'',
			"option"=>"",
			"placeholder"=>"Icd",
			"rules"=>"trim|xss_clean",
			"style"=>"",
			"class"=>"input",
			"can_edit"=>array("Programmer","Admin")
		)
	);
	
	array_push($form["FLD"],array(		
			"id"=>"ICD_Code", 
			"name"=>"ICD_Code",
			"label"=>"",
			"type"=>"hidden",
			"value"=>'',
			"option"=>"",
			"placeholder"=>"Icd",
			"rules"=>"trim|xss_clean",
			"style"=>"",
			"class"=>"input",
			"can_edit"=>array("Programmer","Admin")
		)
	);
}
//if ICD ennabled 
	if(isset($data['hospital']["Visit_SNOMED_Field"])&&( $data['hospital']["Visit_SNOMED_Field"]==1)){
		array_push($form["FLD"],array(		
				"id"=>"SNOMED_Text", 
				"name"=>"SNOMED_Text",
				"label"=>"SNOMED",
				"type"=>"SNOMED",
				"value"=>" ",
				"option"=>"",
				"placeholder"=>"",
				"rules"=>"trim|xss_clean",
				"style"=>"",
				"class"=>"input",
				"can_edit"=>array("Programmer","Admin")
			)
		);
	}
	array_push($form["FLD"],array(		
			"id"=>"SNOMED_Code", 
			"name"=>"SNOMED_Code",
			"label"=>"",
			"type"=>"hidden",
			"value"=>" ",
			"option"=>"",
			"placeholder"=>"",
			"rules"=>"trim|xss_clean",
			"style"=>"",
			"class"=>"input",
			"can_edit"=>array("Programmer","Admin")
		)
	);	
}	//if SNOMED ennabled
array_push($form["FLD"],array(		
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
	)
);	
array_push($form["FLD"],array(		
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
	)
);	

$form["ADDITIONAL_BUTTONS_CONTINUE"] = "opd/view";	
$form["ADDITIONAL_BUTTONS"]=array(
	array("value"=>"Treatment","name"=>"saveoption","id"=>"next1","next1"=>"form/create/opd_treatment"),
	array("value"=>"Prescription","name"=>"saveoption","id"=>"next2","next2"=>"opd/new_prescribe"),
	array("value"=>"Lab order","name"=>"saveoption","id"=>"next6","next6"=>"laboratory/opd_order"),
	array("value"=>"Give injection","name"=>"saveoption","id"=>"next8","next8"=>"form/create/opd_injection/".$this->uri->segment(4)),
	array("value"=>"History","name"=>"saveoption","id"=>"next3","next3"=>"form/create/patient_history/".$this->uri->segment(4)),
	array("value"=>"Allergies","name"=>"saveoption","id"=>"next4","next4"=>"form/create/patient_alergy/".$this->uri->segment(4)),
	array("value"=>"Examination","name"=>"saveoption","id"=>"next5","next5"=>"form/create/patient_exam/".$this->uri->segment(4)),
	array("value"=>"Refer to admission","name"=>"saveoption","id"=>"next7","next7"=>"opd/reffer_to_admission")
);
$patient["JS"] = "
<script>
function ForceSave(){
}
</script>
";  									
////////Configuration for patient form END;                   
?>