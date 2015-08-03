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

class Leftmenu extends MX_Controller {

	 function __construct(){
		parent::__construct();
	 }

	public function preference()
	{
		$this->load->view('left_menu_preference');
	}	
	public function pharmacy()
	{
		$this->load->view('left_menu_pharmacy');
	}	
	public function lab()
	{
		$this->load->view('left_menu_lab');
	}	
	public function procedure_room()
	{
		$this->load->view('left_menu_procedure_room');
	}	
	public function questionnaire()
	{
		$this->load->view('left_menu_questionnaire');
	}	
	public function ward($wid)
	{
		$data["wid"] = $wid;
		$this->load->vars($data);
		$this->load->view('left_menu_ward');
	}	
	public function chat()
	{
		$this->load->view('left_menu_chat');
	}
	public function report()
	{
		$this->load->view('left_menu_report');
	}
		
	public function notification()
	{
		$this->load->view('left_menu_notification');
	}	
	
	public function registry()
	{
		$this->load->view('left_menu_registry');
	}
	
	
	public function patient($id=null,$module=null)
	{
        $data['id']=$id;
		$data['module']=$module;
        $this->load->vars($data);
		$this->load->view('left_menu_patient');
	}		
	
	
	
	public function opd($opdid=null,$pid=null,$opd_info=null)
	{
        
		$data['pid']=$pid;
		$data['opdid']=$opdid;
		$data['opd_info']=$opd_info;

		$data["d_day"]=$opd_info["days"];
        $this->load->vars($data);
		$this->load->view('left_menu_opd');
	}	
	public function clinic($clinic_id=null,$pid=null,$clinic_patient_info=null,$module=null)
	{
        
		$data['pid']=$pid;
		$data['clinic_id']=$clinic_id;
		$data['clinic_patient_info']=$clinic_patient_info;
		$data['module']=$module;
        $this->load->vars($data);
		$this->load->view('left_menu_clinic');
	}
	public function clinic_new($clinic_id=null,$pid=null,$clinic_patient_info=null,$module=null)
	{
        
		$data['pid']=$pid;
		$data['clinic_id']=$clinic_id;
		$data['clinic_patient_info']=$clinic_patient_info;
		$data['module']=$module;
        $this->load->vars($data);
		$this->load->view('left_menu_clinic_new');
	}
	
	public function clinic_patient(){
		//$this->load->vars($data);
		$this->load->view('left_menu_clinic_patient');
	}
	public function admission($admission=null,$pid=null,$order=null)
	{
        
		$data['pid']=$pid;
		$data['admid']=$admission["ADMID"];
		$data['admission']=$admission;
		$data['order_id']=isset($order["admission_prescription_id"])?$order["admission_prescription_id"]:null;
        $this->load->vars($data);
		$this->load->view('left_menu_admission');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */