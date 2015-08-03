<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------

Put all hhims Access configurations here.
This should be  edited by admistrator after new group created. 
--------------------------------------------------------
Standard user groups 		Discription
--------------------------------------------------------
Programmer				: 	
Doctor					: 	
User					: 	
Admin					: 	In PP configuration, can edit and delete table before production mode
Nurse					: 	
LabTech					: 	
Pharm					: 	
Admission				:	
Procedure_Room_Staff	: 	
Visitor					:	
*/
//Table access configuration
$config["table"]["patient"]["can_view"] = 'All';
$config["table"]["patient"]["can_edit"] = array("Programmer","Doctor");
$config["table"]["patient"]["can_create"] = array("Admission","Programmer");
//PP configuration
 if ($this->config->item('purpose') =="PP"){
 	$config["table"]["patient"]["can_create"] = array("Programmer","Doctor");
 	$config["table"]["user"]["can_view"] = 'All';
	$config["table"]["user"]["can_edit"] = array("Programmer","Admin");
	$config["table"]["user"]["can_create"] = array("Programmer","Doctor","Admin");
 }

$config["table"]["opd_visits"]["can_view"] = 'All';
$config["table"]["opd_visits"]["can_edit"] = array("Programmer","Doctor");
$config["table"]["opd_visits"]["can_create"] = array("Admission","Programmer","Doctor");

$config["table"]["admission"]["can_view"] = 'All';
$config["table"]["admission"]["can_edit"] = array("Programmer");
$config["table"]["admission"]["can_create"] = array("Admission","Programmer","Admission","Doctor");

$config["table"]["patient_history"]["can_view"] = 'All';
$config["table"]["patient_history"]["can_edit"] = array("Programmer","Doctor");
$config["table"]["patient_history"]["can_create"] = array("Admission","Programmer","Admission","Doctor");

$config["table"]["qu_question_repos"]["can_view"] = array("Programmer","Doctor");
$config["table"]["qu_question_repos"]["can_edit"] = array("Programmer","Doctor");
$config["table"]["qu_question_repos"]["can_create"] = array("Admission","Programmer","Admission","Doctor");


//leftmenu access configuration
$config["leftmenu"]["patient"]["command"] = 'All';
$config["leftmenu"]["patient"]["print"] = 'All';
$config["leftmenu"]["patient"]["module"] = 'All';


$config["leftmenu"]["preference"]["qmodule"] = array("Programmer","");
$config["leftmenu"]["preference"]["application_table"] = array("Programmer","Doctor", "Admin");

if ($this->config->item('purpose') !="PP"){
	$config["leftmenu"]["preference"]["clinic_table"] = array("Programmer","Doctor");
	$config["leftmenu"]["preference"]["system_table"] = array("Programmer");
}else{
//PP configuration
 	$config["leftmenu"]["preference"]["system_table"] = array("Programmer","Admin");
 	$config["leftmenu"]["preference"]["clinic_table"] = array("Programmer","Admin","Doctor");
}



?>