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
class Hospital extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
	 }

	public function index()
	{

	}
	 public function get_current_bht($cbht=null){
		$this->load->model('mpersistent');
        $data1["hospital_info"] = $this->mpersistent->open_id($this->session->userdata("HID"), "hospital", "HID");
		if ($cbht) {
			$hbht =$cbht;
		}
		else{
			$hbht =$data1["hospital_info"]["Current_BHT"];
		}
		//print_r($data1["hospital_info"]["Current_BHT"]);
		$data = explode('/',$hbht);
		if (count($data) != 3) $bht = "Error";
		$year = date('Y');
		$day = date('d');
		$y = $data[0];
		$y_count = $data[1];
		$m_count = $data[2];
		if ( $day == 1) $m_count = 1;
		if ($y == $year-1) { $y_count = 0;  $m_count = 0; };
		$bht = $year."/".++$y_count."/".++$m_count;
		//echo $bht;
		return $bht;
	}
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */