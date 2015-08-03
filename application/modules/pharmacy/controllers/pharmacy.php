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
class Pharmacy extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
		if(isset($_GET["mid"])){
			$this->session->set_userdata('mid', $_GET["mid"]);
		}			
	 }

	public function index()
	{
		//$this->load->view('patient');
		$this->opd_presciption_search();
	}

	public function show_list($type){
		if ($type == "OPD"){
			$this->opd_presciption_search($type);
		}
		else if($type == "CLN"){
			$this->clinic_presciption_search($type);
		}
	}
	public function opd_presciption_search($type=null){
      $qry = "SELECT 
	  opd_presciption.PID as PID, 
	  opd_presciption.PRSID,
	  opd_presciption.Dept,
	  CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name) as patient_name , 
	  opd_presciption.CreateDate, 
	  opd_presciption.Status 
	  from opd_presciption 
	  LEFT JOIN `patient` ON patient.PID = opd_presciption.PID 
	  where (opd_presciption.Status <> 'Draft')
	  
			";
	if ($type){
		$qry .= "and opd_presciption.Dept = '$type'";
	}
        $this->load->model('mpager',"visit_page");
		
        $visit_page = $this->visit_page;
        $visit_page->setSql($qry);
        $visit_page->setDivId("patient_list"); //important
        $visit_page->setDivClass('');
        $visit_page->setRowid('PRSID');
        $visit_page->setCaption("Prescription list");
        $visit_page->setShowHeaderRow(true);
        $visit_page->setShowFilterRow(true);
        $visit_page->setShowPager(true);
        $visit_page->setColNames(array("","ID","Dept", "Patient", "Date","Status"));
        $visit_page->setRowNum(25);
        $visit_page->setColOption("PID", array("search" => false, "hidden" => true));
        $visit_page->setColOption("PRSID", array("search" => false, "hidden" => false,"width"=>"30px"));
		$visit_page->setColOption("Dept", array("search" => true, "hidden" => false,"width"=>"50px"));
        $visit_page->setColOption("patient_name", array("search" => true, "hidden" => false));
        $visit_page->setColOption("CreateDate", array("search" => false, "hidden" => false ));
        $visit_page->setColOption("Status", array("search" => false, "hidden" => false));
        $visit_page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/pharmacy/dispense")."/'+rowId;
        });
        }";
        $visit_page->setOrientation_EL("L");
		$data['pager'] = $visit_page->render(false);
		$this->load->vars($data);
        $this->load->view('search/prescription_search');	
	}	
	public function clinic_presciption_search($type=null){
      $qry = "SELECT 
	  clinic_prescription.PID as PID, 
	  clinic_prescription.clinic_prescription_id,
	  clinic_prescription.Dept,
	  CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name) as patient_name , 
	  clinic_prescription.CreateDate, 
	  clinic_prescription.Status 
	  from clinic_prescription 
	  LEFT JOIN `patient` ON patient.PID = clinic_prescription.PID 
	  where (clinic_prescription.Status <> 'Draft')
	  
			";
	if ($type){
		$qry .= "and clinic_prescription.Dept = '$type'";
	}
        $this->load->model('mpager',"visit_page");
		
        $visit_page = $this->visit_page;
        $visit_page->setSql($qry);
        $visit_page->setDivId("patient_list"); //important
        $visit_page->setDivClass('');
        $visit_page->setRowid('clinic_prescription_id');
        $visit_page->setCaption("Prescription list");
        $visit_page->setShowHeaderRow(true);
        $visit_page->setShowFilterRow(true);
        $visit_page->setShowPager(true);
        $visit_page->setColNames(array("","ID","Dept", "Patient", "Date","Status"));
        $visit_page->setRowNum(25);
        $visit_page->setColOption("PID", array("search" => false, "hidden" => true));
        $visit_page->setColOption("clinic_prescription_id", array("search" => false, "hidden" => false,"width"=>"30px"));
		$visit_page->setColOption("Dept", array("search" => true, "hidden" => false,"width"=>"50px"));
        $visit_page->setColOption("patient_name", array("search" => true, "hidden" => false));
        $visit_page->setColOption("CreateDate", array("search" => false, "hidden" => false ));
        $visit_page->setColOption("Status", array("search" => false, "hidden" => false));
        $visit_page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/pharmacy/clinic_dispense")."/'+rowId;
        });
        }";
        $visit_page->setOrientation_EL("L");
		$data['pager'] = $visit_page->render(false);
		$this->load->vars($data);
        $this->load->view('search/prescription_search');	
	}		
	public function save_dispense(){
		if($_POST){
			$PRSID = null;
			$drug_stock_id = null;
			$this->load->model('mpersistent');
			$this->load->model('mdrug_stock');
			foreach ($_POST as $k => $v) {
				if ($k == "PRSID"){
					$PRSID = $v;		
				}
				elseif ($k == "drug_stock_id"){
					$drug_stock_id = $v;
				}
				else{
					if ($k[0]!="_"){
						if(isset($_POST["_"+$k])){
							$drug_id = $_POST["_$k"];
						}
						else{
							$drug_id  = null;
						}
						$save_data = array(
							"Quantity" => $v,
							"Status" => "Dispensed"
						);
					
						//update($table=null,$key_field=null,$id=null,$data)
						$r = $this->mpersistent->update("prescribe_items","PRS_ITEM_ID",$k,$save_data);
						if ($r){
							$this->mdrug_stock->deduct_drug($drug_stock_id, $drug_id , $v);
						}
					}
				}
			}
			$save_data = array(
				"Status" => "Dispensed"
			);
			$this->mpersistent->update("opd_presciption","PRSID",$PRSID,$save_data);
			$this->session->set_flashdata(
				'msg', 'REC: ' . 'Dispensed'
			);
			$this->dispense($PRSID);
		}
	}
	public function dispense($prisid){
		if(!isset($prisid) ||(!is_numeric($prisid) )){
			$data["error"] = "Prescription  not found";
			$this->load->vars($data);
			$this->load->view('pharmacy_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->helper('string');
		$data["opd_presciption_info"] = $this->mpersistent->open_id($prisid, "opd_presciption", "PRSID");
		if (empty($data["opd_presciption_info"])){
			$data["error"] ="Prescription not found";
			$this->load->vars($data);
			$this->load->view('pharmacy_error');
			return;
		}
		
		$data['title'] = 'Prescription dispensing';
		if ($data["opd_presciption_info"]["Dept"] == "OPD"){
			$this->load->model('mopd');
			if (isset($data["opd_presciption_info"]["OPDID"])){
				$data["opd_visits_info"] = $this->mopd->get_info($data["opd_presciption_info"]["OPDID"]);
			}
			if (empty($data["opd_visits_info"])){
				$data["error"] ="OPD not found";
				$this->load->vars($data);
				$this->load->view('pharmacy_error');
				return;
			}
			$data["stock_info"] = $this->mopd->get_stock_info($data["opd_visits_info"]["VisitType"]);
			$data["prescribe_items_list"] =$this->mopd->get_prescribe_items($prisid);
			if(isset($data["prescribe_items_list"])){
				for ($i=0;$i<count($data["prescribe_items_list"]); ++$i){
					if ($data["prescribe_items_list"][$i]["drug_list"] == "who_drug"){
						$drug_info = $this->mpersistent->open_id($data["prescribe_items_list"][$i]["DRGID"], "who_drug", "wd_id");
						
					}	
					$data["prescribe_items_list"][$i]["drug_name"] = $drug_info["name"];
					$data["prescribe_items_list"][$i]["drug_dose"] = $drug_info["dose"];
					$data["prescribe_items_list"][$i]["drug_formulation"] = $drug_info["formulation"];
				}
			}
			$data['title'] = 'OPD Prescription dispensing';
		}
		$data['PID'] = $data["opd_presciption_info"]["PID"];
		$this->load->vars($data);
        $this->load->view('drug_dispense');	
	}
	
	public function clinic_dispense($prisid){
		if(!isset($prisid) ||(!is_numeric($prisid) )){
			$data["error"] = "Prescription  not found";
			$this->load->vars($data);
			$this->load->view('pharmacy_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mclinic');
		$this->load->helper('string');
		$data["clinic_prescription_info"] = $this->mpersistent->open_id($prisid, "clinic_prescription", "clinic_prescription_id");
		if (empty($data["clinic_prescription_info"])){
			$data["error"] ="Prescription not found";
			$this->load->vars($data);
			$this->load->view('pharmacy_error');
			return;
		}
		
		$data['title'] = 'Prescription dispensing';
		if ($data["clinic_prescription_info"]["Dept"] == "CLN"){
			//$this->load->model('mopd');
			if (isset($data["clinic_prescription_info"]["clinic_patient_id"])){
				$data["clinic_patient_info"] = $this->mpersistent->open_id($data["clinic_prescription_info"]["clinic_patient_id"], "clinic_patient", "clinic_patient_id");
				$data["clinic_info"] = $this->mclinic->get_clinic_info($data["clinic_patient_info"]["clinic_id"]);
				$data["stock_info"] = $this->mpersistent->open_id($data["clinic_info"]["drug_stock"],"drug_stock", "drug_stock_id");
			}

			$data["prescribe_items_list"] =$this->mclinic->get_prescribe_items($prisid);
			//print_r($data["prescribe_items_list"]);
			//exit;
			if(isset($data["prescribe_items_list"])){
				for ($i=0;$i<count($data["prescribe_items_list"]); ++$i){
					$drug_info = $this->mpersistent->open_id($data["prescribe_items_list"][$i]["DRGID"], "who_drug", "wd_id");
					$data["prescribe_items_list"][$i]["drug_name"] = $drug_info["name"];
					$data["prescribe_items_list"][$i]["drug_dose"] = $drug_info["dose"];
					$data["prescribe_items_list"][$i]["drug_formulation"] = $drug_info["formulation"];
				}
			}
			$data['title'] = $data["clinic_info"]["name"].' Prescription dispensing';
		}
		$data['PID'] = $data["clinic_prescription_info"]["PID"];
		$this->load->vars($data);
        $this->load->view('clinic_drug_dispense');	
	}	
	public function save_clinic_dispense(){
		if($_POST){
			$clinic_prescription_id = null;
			$drug_stock_id = null;
			$this->load->model('mpersistent');
			$this->load->model('mdrug_stock');
			//print_r($_POST);
			//exit;
			foreach ($_POST as $k => $v) {
				if ($k == "clinic_prescription_id"){
					$clinic_prescription_id = $v;		
				}
				elseif ($k == "drug_stock_id"){
					$drug_stock_id = $v;
				}
				else{
					if ($k[0]!="_"){
						if(isset($_POST["_"+$k])){
							$drug_id = $_POST["_$k"];
						}
						else{
							$drug_id  = null;
						}
						$save_data = array(
							"Quantity" => $v,
							"Status" => "Dispensed"
						);
					
						//update($table=null,$key_field=null,$id=null,$data)
						$r = $this->mpersistent->update("clinic_prescribe_items","clinic_prescribe_item_id",$k,$save_data);
						if ($r){
							$this->mdrug_stock->deduct_drug($drug_stock_id, $drug_id , $v);
						}
					}
				}
			}
			$save_data = array(
				"Status" => "Dispensed"
			);
			$this->mpersistent->update("clinic_prescription","clinic_prescription_id",$clinic_prescription_id,$save_data);
			$this->session->set_flashdata(
				'msg', 'REC: ' . 'Dispensed'
			);
			$this->clinic_dispense($clinic_prescription_id);
		}
	}
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */