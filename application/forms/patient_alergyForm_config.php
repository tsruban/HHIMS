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


  			
//patient_alergy
$patient_alergyForm = array();
$patient_alergyForm["OBJID"] = "ALERGYID";
$patient_alergyForm["TABLE"] = "patient_alergy";
$patient_alergyForm["LIST"] = array( 'ALERGYID','Name', 'Status','Remarks','Active');
$patient_alergyForm["DISPLAY_LIST"] = array( 'ID','Name', 'Status','Remarks','Active');
$patient_alergyForm["AUDIT_INFO"] = true;
$patient_alergyForm["NEXT"]  = "home.php?page=patient&PID=".$_GET["PID"]."&action=View&A=";	
$patient_alergyForm["FLD"][0]=array(
                                    "Id"=>"Name", "Name"=>"Allergy",
                                    "Type"=>"text",  "Value"=>"",
                                    "Help"=>"Name of the allergy", "Ops"=>"",
                                    "valid"=>"*"
                                    );
 $patient_alergyForm["FLD"][1]=array(
                                    "Id"=>"Status",    "Name"=>"Status",  "Type"=>"select",
                                    "Value"=>array("Past","Current"),   "Help"=>"Status of the alergy",  "Ops"=>"",
                                    "valid"=>""
                                    );                                   
$patient_alergyForm["FLD"][2]=array(
                                    "Id"=>"Remarks", "Name"=>"Remarks",    "Type"=>"remarks",
                                    "Value"=>"",     "Help"=>"Any remarks (Canned text enabled)",   "Ops"=>"",
                                    "valid"=>""
                                    );
$patient_alergyForm["FLD"][3]=array(
                                    "Id"=>"Active",    "Name"=>"Active",  "Type"=>"bool",
                                    "Value"=>"",   "Help"=>"Active or not ",  "Ops"=>"",
                                    "valid"=>""
                                    );
	$patient_alergyForm["FLD"][4]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
     $patient_alergyForm["FLD"][5]=array(
                                    "Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],
                                    "Help"=>"", "Ops"=>""
                                    );  
  
$patient_alergyForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
/*     $patient_alergyForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $patient_alergyForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"Cancel", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>