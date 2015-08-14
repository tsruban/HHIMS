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
*/
/*
Put all hhims configurations here 
access them by  
$this->config->item('purpose');
*/
$config["purpose"] = "GH"; //GH:Governent hospital, PC: Pain Clinic, PP : Private Practice

$config["title"] = "HHIMS V2.1";
$config["app_name"] = "HHIMS";
$config["debug"] = false;
$config["flash_time"] = 2;//sec
$config["auto_logout_time"] = 10000; //300sec (5 min)
$config["drug_alert_count"] = 10; 
$config["save_confirm"] = true; // Alerts when there is unsaved data in the forms 

$config["default_bck_color"] = "#CFCFCF"; 
$config["opd_bck_color"] = "#A3BBA5"; 
$config["admission_bck_color"] = "#ACB6C5"; 
$config["clinic_bck_color"] = "#C4AEAE"; 
$config["block_opd_after"] = 1;  // day
$config["regular_hours"] = array('06','09','12','15','18','21');  // hrs

//Add your email server details for sending notification emails
$config['mail_protocol'] = 'smtp';
$config['mail_smtp_host'] = '';
$config['mail_smtp_port'] = 25;
$config['mail_smtp_smtp_timeout'] = 30;
$config['mail_smtp_user'] = '';
$config['mail_smtp_pass'] = '';
$config['mail_smtp_sender'] = '';

//Factor
$config["once_a_day"] = 1; 
$config["bd"] = 2; 
$config["tds"] = 3; 
$config["qds"] = 4; 
$config["nocte"] = 1; 
$config["stat"] = 1; 
$config["For 1 day"] = 1;
$config["For 2 days"] = 2; 
$config["For 3 days"] = 3; 
$config["For 4 days"] = 4; 
$config["For 5 days"] = 5; 
$config["For 1 week"] = 7; 
$config["For 2 weeks"] = 14; 
$config["For 3 weeks"] = 21; 
$config["For 1 month"] = 30; 


$config["disclaimer"] = 
						'This software holds a record of patient information 
						entered by hospital staff. It does not give any clinical 
						advice and is not involved in the diagnosis nor the treatment 
						of patients. While the ICTA and Lunar Technologies have taken 
						every effort in the production of this software to ensure that 
						the information entered by the user is correctly recorded and displayed, 
						it is ultimately the user of the system who takes full responsibility 
						for the accuracy of this information.'; 

//File upload config
$config['upload_path'] = 'attach/';
$config['upload']['upload_path'] = './attach/';
$config['upload']['allowed_types'] = 'gif|jpg|png';
//$config['upload']['max_size']	= '2048';
//$config['upload']['max_width']  = '2048';
//$config['upload']['max_height']  = '2048';
$config['upload']['encrypt_name']  = true;

$config['diagram']['diagram_path'] = './attach/diagram/';
$config['diagram']['upload_path'] = './attach/diagram/';
$config['diagram']['allowed_types'] = 'gif|jpg|png';
//$config['diagram']['max_width']  = '2048';
//$config['diagram']['max_height']  = '2048';
$config['diagram']['encrypt_name']  = true;

// Report config
$config['report']['token_text']="Please hand this token to doctor";
?>
