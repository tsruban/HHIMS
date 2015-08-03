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

/*
CREATE TABLE IF NOT EXISTS `patient_exam` (
  `PATEXAMID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` varchar(50) NOT NULL ,
  `Weight` int(4)  ,
  `Height` int(4)  ,
  `sys_BP` int(4)  ,
  `diast_BP` int(4)  ,
  `Temprature` int(4)  ,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`PATEXAMID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;
ALTER TABLE patient_exam ADD COLUMN `ExamDate` datetime ;
*/
  			
//ppatient_history
$patient_examForm = array();
$patient_examForm["OBJID"] = "PATEXAMID";
$patient_examForm["TABLE"] = "patient_exam";
$patient_examForm["LIST"] = array( 'PATEXAMID','Name', 'Status','Remarks','Active');
$patient_examForm["DISPLAY_LIST"] = array( 'ID','Name', 'Status','Remarks','Active');
$patient_examForm["AUDIT_INFO"] = true;
$patient_examForm["NEXT"]  = "home.php?page=patient&PID=".$_GET["PID"]."&action=View&A=";	

$patient_examForm["FLD"][0]=array(
                                    "Id"=>"ExamDate", "Name"=>"Examination Date",
                                    "Type"=>"datetime",  "Value"=>date("Y-m-d h:i:s"),
                                    "Help"=>"Examination Date", "Ops"=>"",
                                    "valid"=>"*"
                                    );
$patient_examForm["FLD"][1]=array (
                                    "Id"=>"Weight",    "Name"=>"Weight in Kg",  "Type"=>"number",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>" min = 0 max =300 step=5",
                                    "valid"=>""
                                    );
$patient_examForm["FLD"][2]=array(
                                    "Id"=>"Height",    "Name"=>"Height in M",  "Type"=>"number",
                                    "Value"=>"",   "Help"=>" ",  "Ops"=>"min = 0 max =2,5 step=0.1",
                                    "valid"=>""
                                    );
$patient_examForm["FLD"][3]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );   									
$patient_examForm["FLD"][4]=array(
                                    "Id"=>"sys_BP",    "Name"=>"sys BP",  "Type"=>"number",
                                    "Value"=>"120",   "Help"=>" ",  "Ops"=>" min = 50 max=300 step=5 normal=120",
                                    "valid"=>""
                                    );
									

$patient_examForm["FLD"][5]=array(
								"Id"=>"diast_BP",     "Name"=>"diast BP",    "Type"=>"number",     "Value"=>"80",
								"Help"=>"", "Ops"=>" min = 20 max =200 step=5 normal=80"
								);   
$patient_examForm["FLD"][6]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    ); 			
$patient_examForm["FLD"][7]=array(
								"Id"=>"Temprature",     "Name"=>"Temperature in 'c",    "Type"=>"number",     "Value"=>"36.6",
								"Help"=>"", "Ops"=>" min = 15 max =50 step=0.5 normal=36,6"
								);   									
$patient_examForm["FLD"][8]=array(
								"Id"=>"Active",     "Name"=>"Active",    "Type"=>"bool",     "Value"=>"",
								"Help"=>"Diagnosis active or not", "Ops"=>""
								);     		
	$patient_examForm["FLD"][9]=array(
                                    "Id"=>"_", "Name"=>"",   "Type"=>"line",     "Value"=>"",     "Help"=>"",   "Ops"=>""
                                    );          
     $patient_examForm["FLD"][10]=array(
                                    "Id"=>"PID",     "Name"=>"pid",    "Type"=>"hidden",     "Value"=>$_GET["PID"],
                                    "Help"=>"", "Ops"=>""
                                    );  
  
$patient_examForm["BTN"][0]=array(
                                   "Id"=>"SaveBtn",    "Name"=>"Save",   "Type"=>"button", "Value"=>"Save",     
                                    "Help"=>"",   "Ops"=>"",  "onclick"=>"saveData()",
                                    "Next"=>""
                                    );                                            
/*     $patient_examForm["BTN"][1]=array(
                                   "Id"=>"ClearBtn",    "Name"=>"Clear", "Type"=>"button",  "Value"=>"Clear", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"clearForm()",
                                   "Next"=>""
                                    );  
*/									
     $patient_examForm["BTN"][1]=array(
                                   "Id"=>"CancelBtn",    "Name"=>"OK", "Type"=>"button",  "Value"=>"OK", 
                                   "Help"=>"", "Ops"=>"", "onclick"=>"window.history.back()",
                                   "Next"=>""
                                    );   									
/////////////////////////ICD FORM END		
?>