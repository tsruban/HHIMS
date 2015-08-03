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
class Appointment extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
		$this->load->helper('text');
	 }

	public function index()
	{
		return;
	}
	
	public function patient(){
       $qry = "SELECT clinic_patient.PID as PID, clinic_patient.clinic_patient_id,CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name) as patient_name , clinic.name as clinic_name, 
			next_visit_date from clinic_patient 
			LEFT JOIN `patient` ON patient.PID = clinic_patient.PID 
			LEFT JOIN `clinic` ON clinic.clinic_id = clinic_patient.clinic_id 
			";
        $this->load->model('mpager',"visit_page");
        $visit_page = $this->visit_page;
        $visit_page->setSql($qry);
        $visit_page->setDivId("patient_list"); //important
        $visit_page->setDivClass('');
        $visit_page->setRowid('clinic_patient_id');
        $visit_page->setCaption("Previous visits");
        $visit_page->setShowHeaderRow(false);
        $visit_page->setShowFilterRow(false);
        $visit_page->setShowPager(false);
        $visit_page->setColNames(array("","ID", "Patient", "Next visit date","Clinic "));
        $visit_page->setRowNum(25);
        $visit_page->setColOption("PID", array("search" => false, "hidden" => true));
        $visit_page->setColOption("clinic_patient_id", array("search" => false, "hidden" => true));
        $visit_page->setColOption("patient_name", array("search" => true, "hidden" => false));
        $visit_page->setColOption("next_visit_date", array("search" => false, "hidden" => false, "width" => 75));
        $visit_page->setColOption("clinic_name", array("search" => false, "hidden" => false, "width" => 75));
        $visit_page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/appointment/open")."/'+rowId;
        });
        }";
        $visit_page->setOrientation_EL("L");
		$data['pager'] = $visit_page->render(false);
		$this->load->vars($data);
        $this->load->view('clinic_search');	
       
	}	
	public function save(){
		$this->load->model('mpersistent');
		$this->load->model('mappointment');
		$this->load->helper('form');
        $this->load->library('form_validation');
		
        $this->form_validation->set_rules("VDate", "VDate", "required|xss_clean");
        $this->form_validation->set_rules("Type", "Type", "required|xss_clean");
        $this->form_validation->set_rules("Consultant", "Consultant", "required|xss_clean");
        $this->form_validation->set_rules("PID", "PID", "required|xss_clean");
		
        $data = array();
		$this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
            echo Modules::run('form/create', 'appointment');
        } else {
			$token = $this->mappointment->get_next_token($this->input->post("VDate"),$this->input->post("Type"));
			$sve_data = array(
					"VDate"=>$this->input->post("VDate"),
					"Type"=>$this->input->post("Type"),
					"Consultant"=>$this->input->post("Consultant"),
					"PID"=>$this->input->post("PID"),
					"Token"=>$token+1
				);
			$appid = $this->mpersistent->create("appointment", $sve_data);
			if ($appid>0){
				$this->open($appid);
					$new_page   =   base_url()."index.php/appointment/open/".$appid."?CONTINUE=".$this->input->post("CONTINUE")."";
					header("Status: 200");
					header("Location: ".$new_page);
			}
			else{
				$data["error"] ="save error";
				$this->load->vars($data);
				$this->load->view('appointment_error');
				return;
			}
		}
	}

	
	public function open($appid){
		$data = array();
		if(!isset($appid) ||(!is_numeric($appid) )){
			$data["error"] = "Appointment not found";
			$this->load->vars($data);
			$this->load->view('appointment_error');	
			return;
		}
		$this->load->model('mpersistent');
        $data["appointment_info"] = $this->mpersistent->open_id($appid,"appointment", "APPID");
		if (empty($data["appointment_info"])){
			$data["error"] = "Appointment not found";
			$this->load->vars($data);
			$this->load->view('appointment_error');	
			return;
		}
		
		 
        $data["patient_info"] = $this->mpersistent->open_id($data["appointment_info"]["PID"],"patient", "PID");
		if (empty($data["patient_info"])){
			$data["error"] ="patient_info  not found";
			$this->load->vars($data);
			$this->load->view('appointment_error');
			return;
		}
		$data["dr_info"] = $this->mpersistent->open_id($data["appointment_info"]["Consultant"],"user", "UID");
		if (empty($data["dr_info"])){
			$data["error"] ="Doctor  not found";
			$this->load->vars($data);
			$this->load->view('appointment_error');
			return;
		}
		$this->load->vars($data);
        $this->load->view('appointment_view');	
	}
	
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */