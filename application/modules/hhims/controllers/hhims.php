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
class Hhims extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
        $this->load->helper('form');
		$this->load->model('mmenu');
		$this->load->library('MdsCore');
	 }
	public function index()
	{
	
		$default_module = $this->mmenu->get_home_menu($this->session->userdata('UserGroup'));	
		//$data['user_home_menu'] = $this->mmenu->get_home_menu($this->session->userdata('UserGroup'));
		$data['module_name']        =   $this->uri->segment(1);
        $data['module_controller']  =   $this->uri->segment(2);
        $data['module_method']      =   $this->uri->segment(3);
        $data['seg3']               =   $this->uri->segment(4);
        $data['seg4']               =   $this->uri->segment(5);
        $data['seg5']               =   $this->uri->segment(6);
        $data['seg6']               =   $this->uri->segment(7);
        $data['seg7']               =   $this->uri->segment(8);
        $data['seg8']               =   $this->uri->segment(9);
		
		$data['main'] = 'home';
        if ($this->config->item('debug')){
			//$this->mdscore->print_debug($data);
			$this->mdscore->print_debug($default_module);
		}
        //$refresh_seconds        =   30;
        //$refresh_ms             =   1000 * $refresh_seconds;
       // $data['auto_refresh']   =    "";
        //if($data['module_controller'] == "ehr_dashboard"){
            //$data['auto_refresh']   =    "onload='timed_refresh(".$refresh_ms.");'";
       // }
        $home_page   =   base_url()."index.php/".$default_module["MainMenu"];
		header("Status: 200");
		header("Location: ".$home_page);       
		//$this->load->vars($data);
		//$this->load->view('hhims');
	}
	public function get_user_info(){
			echo '<span class="usr_info">';
				echo $this->session->userdata('Title').' ';
				echo $this->session->userdata('FirstName').' ';
				echo '('.$this->session->userdata('UserGroup').')';
			echo'</span>';
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */