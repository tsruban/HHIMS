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

class Menu extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->model('mmenu');
		//PP configuration
		if ($this->config->item('purpose') =="PP"){
			$data['user_menu'] = $this->mmenu->get_menu_list_for_PP($this->session->userdata('UserGroup'));
		}else{
			$data['user_menu'] = $this->mmenu->get_menu_list($this->session->userdata('UserGroup'));
		}
		$this->load->vars($data);
		$this->load->view('top_menu');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */