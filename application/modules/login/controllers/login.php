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

session_start();
class Login extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->model('mlogin');
		$this->load->library('class/MDSLicense','','MDSLicense');
		$this->MDSLicense->readKey('mdsfoss.key');
    }

	public function index()
	{
		$data['title'] = $this->config->item('title');
		$this->load->vars($data);
		$this->load->view('login');
	}
	
	public function auth(){
		$username  = trim($this->input->post('username'));
        $password  = trim($this->input->post('password'));
		$hospital  = trim($this->input->post('LIC_HOS'));
		$data['user_info'] = $this->mlogin->do_auth($username,$password);
		
		 if(isset($data['user_info'])){
            if (isset($data['user_info']['UID'])&&($data['user_info']['UID'] > 0)) {
                $this->session->set_userdata('UID', $data['user_info']['UID']);
                $this->session->set_userdata('HID', $data['user_info']['HID']);
                $this->session->set_userdata('last_prescription_cmd', $data['user_info']['last_prescription_cmd']);
				$this->session->set_userdata('Title', $data['user_info']['Title']);
				$this->session->set_userdata('FirstName', $data['user_info']['FirstName']);
				$this->session->set_userdata('Post', $data['user_info']['Post']);
				$this->session->set_userdata('UserName', $data['user_info']['UserName']);
				$this->session->set_userdata('FullName', $data['user_info']['Title']." ".$data['user_info']['FirstName']." ".$data['user_info']['OtherName']);
				$this->session->set_userdata('UserGroup', $data['user_info']['UserGroup']);
				$this->session->set_userdata('Hospital',$hospital);
				$this->session->set_userdata('DefaultLanguage', $data['user_info']['DefaultLanguage']);

				//PP configuration			
				// Save the status : config or production		
            if ($this->config->item('purpose') == "PP" ){
					$dataset = array();
						$sql = "SELECT * FROM `PP_Status` ";
						$Q =  $this->db->query($sql);
						foreach ($Q->result_array() as $row) {
							$dataset = $row;
						}
	       				$Q->free_result(); 
	       				
	       				//Check the actual status
					if ($dataset['Status'] == 'configuration'){
						 if ($data['user_info']['UserGroup']== "Admin" || $data['user_info']['UserGroup']== "Programmer"){
						 	$this->session->set_userdata('Config','config_admin');
						 }else{
						 	$this->session->set_userdata('Config','config_other');
						 //	echo '<script> alert ("Please contact your administrator to start production");</script>';
						 }
					}else{
						$this->session->set_userdata('Config','production');
					}
            }
				
				
				
				$data['hospital_info'] = $this->mlogin->get_hospital($data['user_info']['HID']);	
				$this->session->set_userdata('hospital_info', $data['hospital_info']);
				//print_r($this->session->all_userdata());
				
				$this->mlogin->set_online($data['user_info']['UID']);
				$this->load->library('user_agent');
				if ($this->agent->is_browser()){
					$data['agent'] = $this->agent->browser().' '.$this->agent->version();
				} elseif ($this->agent->is_robot()) {
					$data['agent'] = $this->agent->robot();
				} elseif ($this->agent->is_mobile()) {
					$data['agent'] = $this->agent->mobile();
				} else {
					$data['agent'] = 'Unidentified User Agent';
				} 
				$data['title'] = $this->config->item('title');
				$data['main'] = 'home';
				//print_r($data['hospital_info']);
				$this->load->vars($data);
				$new_page   =   base_url()."index.php/hhims";
				header("Status: 200");
				header("Location: ".$new_page);
				
			}
			else{
				$new_page   =   base_url()."index.php/login?err=InValid";
				header("Status: 200");
				header("Location: ".$new_page);
			}
		}
	}
	
	function logout()
    {
		$this->mlogin->set_logout($this->session->userdata('UID'));
		unset($_SESSION);
        $this->session->sess_destroy();
		session_destroy();
        $new_page   =   base_url()."index.php";
		header("Location:".$new_page);
    } 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */