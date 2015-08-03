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
----------------------------------------------------------------------------------
*/

session_start();
class Security extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model("mpersistent");
    }

	public function index()
	{	
		return;
	}
	/*
		THis is function to check the filed edit access.
		It defiled in application/forms/[in each files]
	*/
	public function check_access_for_edit($ug_list){
		if (in_array($this->session->userdata('UserGroup'), $ug_list)){
			return true;
		}
		else{
			return false;
		}
	}
	
	/*
		THis is function to check view access
		It defiled in application/config/hhims_access_config.php
		$config["table"]["patient"]["can_view"] = array("","Doctor");//array("Programmer","Doctor"); or 'All'
		$config["table"]["patient"]["can_edit"] = array("Programmer","Doctor");
		$config["table"]["patient"]["can_create"] = array("Admission","Programmer");
	*/
	public function check_view_access($table,$view){
		if (!file_exists('application/config/hhims_access_config.php')){
			die("Form 'config/hhims_access_config' not found");
		}
		include 'application/config/hhims_access_config.php';
		if (isset($config["table"][$table][$view])){
			if ($config["table"][$table][$view] == "All"){
				return true;
			}
			else{
				if (count($config["table"][$table][$view]) > 0 ){
					if (in_array($this->session->userdata('UserGroup'), $config["table"][$table][$view])){
						 return true;
					}
					else{
						 return false;
					}
				}
				return true;
			}
		}
		return true;
	}


	/*
		THis is function to check create access
		It defiled in application/config/hhims_access_config.php
		$config["table"]["patient"]["can_create"] = array("Admission","Programmer");
	*/
	public function check_create_access($table,$create){
		if (!file_exists('application/config/hhims_access_config.php')){
			die("Form 'config/hhims_access_config' not found");
		}
		include 'application/config/hhims_access_config.php';
		if (isset($config["table"][$table][$create])){
			if ($config["table"][$table][$create] == "All"){
				return true;
			}
			else{
				if (count($config["table"][$table][$create]) > 0 ){
					if (in_array($this->session->userdata('UserGroup'), $config["table"][$table][$create])){
						 return true;
					}
					else{
						 return false;
					}
				}
				return true;
			}
		}
		return true;
	}	
	
	/*
		THis is function to check edit access
		It defiled in application/config/hhims_access_config.php
		$config["table"]["patient"]["can_edit"] = array("Admission","Programmer");
	*/
	public function check_edit_access($table,$edit){
		if (!file_exists('application/config/hhims_access_config.php')){
			die("Form 'config/hhims_access_config' not found");
		}
		include 'application/config/hhims_access_config.php';
		if (isset($config["table"][$table][$edit])){
			if ($config["table"][$table][$edit] == "All"){
				return true;
			}
			else{
				if (count($config["table"][$table][$edit]) > 0 ){
					if (in_array($this->session->userdata('UserGroup'), $config["table"][$table][$edit])){
						 return true;
					}
					else{
						 return false;
					}
				}
				return true;
			}
		}
		return true;
	}		
	/*
		THis is function to check edit access
		It defiled in application/config/hhims_access_config.php
		$config["table"]["patient"]["can_edit"] = array("Admission","Programmer");
	*/
	public function check_leftmenu_access($page,$leftmenu){
		if (!file_exists('application/config/hhims_access_config.php')){
			die("Form 'config/hhims_access_config' not found");
		}
		
		include 'application/config/hhims_access_config.php';
		
		if (isset($config["leftmenu"][$page][$leftmenu])){
			if ($config["leftmenu"][$page][$leftmenu] == "All"){
				return true;
			}
			else{
				if (count($config["leftmenu"][$page][$leftmenu]) > 0 ){
					print_r($config["leftmenu"][$page][$leftmenu]);
					if (in_array($this->session->userdata('UserGroup'), $config["leftmenu"][$page][$leftmenu])){
						 return true;
					}
					else{
						 return false;
					}
				}
				return true;
			}
		}
		
		return true;
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */