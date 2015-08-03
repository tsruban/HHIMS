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

class Form extends MX_Controller {
	private $form;
	
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('MdsCore');
		$this->load->database();
		$this->load->model("mpersistent");
		$this->load->library('session');
	 }
	 
	 public function delete($frm=NULL,$id=NULL)
	{
		//PP configuration
		//add conditions that allows privileges to the admin in config mode in PP mode 
		if ($this->session->UserData("Config") != 'config_admin' && $this->session->userdata('UserGroup') != 'Programmer' ){	
			die('Dont have enough privilages');
		}
		//This function is called throught JQuery so arguments are sent with GET
		if ($this->session->UserData("Config") == 'config_admin'){
			$frm = $_GET['table'];
			$id = $_GET['row'];
		}
		
		if (!isset($frm)){
			die("Form ".$frm."  not found");
		}
		if (!file_exists('application/forms/'.$frm.'.php')){
			die("Form ".$frm."  not found");
		}
		include 'application/forms/'.$frm.'.php';
			
		if (!$frm) die('Table not defined');
		if (!$id) die('ID not defined');
		if (!is_numeric($id))die('ID not valid');
		$this->load->database();
		$this->db->delete($form["TABLE"], array($form["OBJID"] => $id)); 
		$this->session->set_flashdata('msg', ucfirst($form["TABLE"]).' ID('.$id.') Deleted' );
		redirect(base_url().'index.php/'.$form["NEXT"], '');
		//echo "<script>window.history.back(0)</script>";
	}
	
public function edit($frm=NULL,$id=NULL)
	{
		//PP configuration
		//This function is called throught JQuery with GET
		if ($this->session->UserData("Config") == 'config_admin'){
			$frm = $_GET['table'];
			$id = $_GET['row'];
		}
		
		if (!isset($frm)){
			die("Form ".$frm."  not found");
		}
		if (!file_exists('application/forms/'.$frm.'.php')){
			die("Formulaire ".$frm."  not found");
		}
		if (!Modules::run('security/check_edit_access',$frm,'can_edit')){
			$data["error"] =" User group '".$this->session->userdata('UserGroup')."' have no rights to edit '".$frm."' data. ";
			$this->load->vars($data);
			$this->load->view('form_error');
			exit;
		}
		
		$data= array();
		$data["hospital"] =  $this->mpersistent->open_id(1,'hospital','HID');
		$this->load->vars($data);
		include 'application/forms/'.$frm.'.php';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
		for ( $i=0; $i < count($form["FLD"]); ++$i ){
			$this->form_validation->set_rules($form["FLD"][$i]["name"], '"'.$form["FLD"][$i]["label"].'"', $form["FLD"][$i]["rules"]);
		}
		
		$this->form_validation->set_rules($form["OBJID"]);
	//	die(print_r($form));
		$data["form"]=$form;
		for ( $i=0; $i < count($form["FLD"]); ++$i ){
		
				if ($form["FLD"][$i]["type"] == "table_select"){
					$data[$form["FLD"][$i]["id"]] = $this->mpersistent->table_select($form["FLD"][$i]["sql"]);
				}
				if ($form["FLD"][$i]["type"] == "object"){
					$data[$form["FLD"][$i]["id"]] = $this->mpersistent->open_id($form["FLD"][$i]["value"],$form["FLD"][$i]["table"],$form["FLD"][$i]["id"]);
				}
		}
		
		$data["id"]=$id;
		//die(print_r($id));
		$data['value'] = $this->mpersistent->open_id($id,$form["TABLE"],$form["OBJID"]);
		//die(print_r($data['value']));
		if ($this->config->item('debug')){
				//$this->mdscore->print_debug($data["value"]);
				//$this->mdscore->print_debug($_POST);
		}
		
		$this->load->vars($data);
		$this->load->view('form_render');
	}
		
	public function create($frm=NULL)
	{	
		
		if (!isset($frm)){
			die("Form ".$frm."  not found");
		}
		if (!file_exists('application/forms/'.$frm.'.php')){
			die("Form ".$frm."  not found");
		}
		
		if (!Modules::run('security/check_create_access',$frm,'can_create')){
			$data["error"] =" User group '".$this->session->userdata('UserGroup')."' have no rights to create '".$frm."' data.";
			$this->load->vars($data);
			$this->load->view('form_error');
			exit;
		}
		
		$this->load->helper('form');
		$data= array();
		$data["hospital"] =  $this->mpersistent->open_id(1,'hospital','HID');
		$this->load->vars($data);
		include 'application/forms/'.$frm.'.php';
		$data["form"]=$form;
		for ( $i=0; $i < count($form["FLD"]); ++$i ){
			if ($form["FLD"][$i]["type"] == "table_select"){
				$data[$form["FLD"][$i]["id"]] = $this->mpersistent->table_select($form["FLD"][$i]["sql"]);
			}
			if ($form["FLD"][$i]["type"] == "object"){
				$data[$form["FLD"][$i]["id"]] = $this->mpersistent->open_id($form["FLD"][$i]["value"],$form["FLD"][$i]["table"],$form["FLD"][$i]["id"]);
			}
		}
		if ($this->config->item('debug')){
			$this->mdscore->print_debug($data);
			//$this->mdscore->print_debug($_POST);
		}
		//print_r($data);
		if (isset($form["LEFT_BAR"])){
			if (count($form["LEFT_BAR"])>0){
				$data["left_bar"] = $form["LEFT_BAR"];
			}
		}
		$this->load->vars($data);
		$this->load->view('form_render');

	}
	
	public function save($frm){
		
		if (!isset($frm)){
			die("Form ".$frm."  not found");
		}
		if (!file_exists('application/forms/'.$frm.'.php')){
			die("Form ".$frm."  not found");
		}
		include 'application/forms/'.$frm.'.php';
		$data["form"]=$form;
		//dprint_r($_POST);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
		for ( $i=0; $i < count($form["FLD"]); ++$i ){
			$this->form_validation->set_rules($form["FLD"][$i]["name"], '"'.$form["FLD"][$i]["label"].'"', $form["FLD"][$i]["rules"]);
		}
		$this->form_validation->set_rules($form["OBJID"]);
		if ($this->form_validation->run() == FALSE){
			for ( $i=0; $i < count($form["FLD"]); ++$i ){
				if ($form["FLD"][$i]["type"] == "table_select"){
					$data[$form["FLD"][$i]["id"]] = $this->mpersistent->table_select($form["FLD"][$i]["sql"]);
				}
				if ($form["FLD"][$i]["type"] == "object"){
					$data[$form["FLD"][$i]["id"]] = $this->mpersistent->open_id($_POST[$form["FLD"][$i]["name"]],$form["FLD"][$i]["table"],$form["FLD"][$i]["id"]);
				}
			}
			$this->load->vars($data);
			$this->load->view('form_render');
		}
		else{
			$sve_data = array();
			for ( $i=0; $i < count($form["FLD"]); ++$i ){
				if (($form["FLD"][$i]["name"]!="CONTINUE")&&($form["FLD"][$i]["type"]!="label"))
					$sve_data[$form["FLD"][$i]["name"]] = $this->input->post($form["FLD"][$i]["name"]);
			}	
			$id = $_POST[$form["OBJID"]];
			if ($id>0) {
				if (isset($form["SAVE_TABLE"])&&($form["SAVE_TABLE"]!="")){
					$save_table =$form["SAVE_TABLE"];
				}
				else{
					$save_table  =$frm;
				}
		
				
				$status = $this->mpersistent->update($save_table,$form["OBJID"],$id,$sve_data);
			}
			else{
				if (isset($form["UNIQUE_ID"]) && ($form["UNIQUE_ID"]==1)){
					$sve_data[$form["OBJID"]] = $this->get_unique_id();
				}
				if (isset($form["SAVE_TABLE"])&&($form["SAVE_TABLE"]!="")){
					$save_table =$form["SAVE_TABLE"];
				}
				else{
					$save_table  =$frm;
				}
				$status = $this->mpersistent->create($save_table,$sve_data);
			}
			if ($status>=0){
				$this->session->set_flashdata('msg', ucfirst($form["TABLE"]).' Saved' );
				if (isset($_POST["CONTINUE"])){
					header("Status: 200");
					header("Location: ".site_url($_POST["CONTINUE"])); 
				}
				elseif(isset($_POST["saveoption"])){
					header("Status: 200");
					header("Location: ".site_url($_POST[$_POST["saveoption"]].'/'.$status.'/?CONTINUE='.$form["ADDITIONAL_BUTTONS_CONTINUE"].'/'.$status)); 
				}
				else{
					header("Status: 200");
					header("Location: ".base_url()."index.php/".$form["NEXT"]."/".$status); 
				}
				
				//print_r($form["NEXT"]);
				//Modules::run("preference");
			}
			else{
				echo "ERROR in saving";
			}
		}
	}	
	
	private function get_unique_id(){
		$yyyy = substr(date("Y/m/d"),0,4);
		$mm = substr(date("Y/m/d"),5,2);
		$dd = substr(date("Y/m/d"),8,2);
		//echo $yyyy.$mm.$dd.substr(number_format(str_replace(".","",microtime(true)*rand()),0,'',''),0,14);
		//echo $yyyy.$mm.$dd.time();
		//echo $yyyy.$mm.$dd.substr(number_format(str_replace(".","",microtime(true)*rand()),0,'',''),0,8);
		//return $yyyy.$mm.$dd.substr(number_format(str_replace(".","",microtime(true)*rand()),0,'',''),0,8);
		return substr(number_format(str_replace(".","",microtime(true)*rand()),0,'',''),0,8);
	}	
/*
	public function save($form){
		if ($this->config->item('debug')){
			$this->mdscore->print_debug($form);
			$this->mdscore->print_debug($_POST);
		}
		
		$this->load->database();		
		if ( set_value( $form["OBJID"] ) > 0 ){
				$data = array();
				$query = $this->db->query('SELECT * FROM '.$form["TABLE"]); 
				foreach ($query->list_fields() as $field)
				{
					if (set_value($field)){
						$data[$field] = set_value($field);
					}
				}
			$this->db->where($form["OBJID"], set_value($form["OBJID"]));
			$this->db->update($form["TABLE"], $data); 		
			$this->session->set_flashdata('msg', ucfirst($form["TABLE"]).' Updated' );
			redirect(base_url().'index.php/'.$form["NEXT"], '');
			//echo "<script>window.history.back(-2)</script>";
		}
		else{
			$query = $this->db->query('SELECT * FROM '.$form["TABLE"]); 
			foreach ($query->list_fields() as $field)
			{
				if (set_value($field)){
					$this->db->set($field, set_value($field));
				}
			}
			$this->db->insert($form["TABLE"]); 
			$this->session->set_flashdata('msg', ucfirst($form["TABLE"]).' Created' );
			redirect(base_url().'index.php/'.$form["NEXT"], '');
			//echo "<script>window.history.back(0)</script>";
		}
	}
*/


} //end class

function sanitize($data){
	$data=trim($data);
	$data=htmlspecialchars($data);
	$data = mysql_escape_string($data);
	$data = stripslashes($data);
	return $data;
}

function cleanName($text){
	$text = preg_replace('/[\x00-\x1F\x7F\<\>\,\"\'\(\)\{\}\[\]\/\%\$\#\@\;\:\^\?\/\\\+\-\=\*\&0-9]/', '', $text);
	$possible_injection = array("SCRIPT", "script", "ScRiPt","PHP","php","alert","eval","java","type","hello");
	$replace   = array("", "", "","", "", "","");
	$text = str_replace($possible_injection, $replace, $text);
	return sanitize($text);
}

function cleanNumber($text){
	$text = preg_replace('/[\x00-\x1F\x7F\<\>\,\"\'\(\)\{\}\[\]\/\%\$\#\@\;\:\^\?\/\\\+\*\&]/', '', $text);
	$possible_injection = array("SCRIPT", "script", "ScRiPt","PHP","php","alert","eval");
	$replace   = array("", "", "","", "", "","");
	$text = str_replace($possible_injection, $replace, $text);
	return sanitize($text);
}        

function nic_check($str)
{

		return TRUE;

}

function checkDOB($dob){
	$reg = '/^(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/';
	return preg_match($reg,$dob);
}  
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */