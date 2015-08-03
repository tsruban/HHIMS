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

class Admission extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
		$this->load->helper('text');
		if(isset($_GET["mid"])){
			$this->session->set_userdata('mid', $_GET["mid"]);
		}
	}

	public function index()
	{

	}
	public function create($pid){
		$data = array();
		$this->load->vars($data);
        $this->load->view('admission_new');	
	}
	

public function proceed($opdid){
		$data = array();
		if(!isset($opdid) ||(!is_numeric($opdid) )){
			$data["error"] = "OPD visit not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mopd');
		$this->load->model('mpatient');
		$this->load->helper('form');
        $this->load->library('form_validation');
        $data["opd_visits_info"] = $this->mopd->get_info($opdid);

		if ($data["opd_visits_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["opd_visits_info"]["PID"], "patient", "PID");
		}
		else{
			$data["error"] = "OPD Patient  not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="OPD Patient not found";
			$this->load->vars($data);
			$this->load->view('opd_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		$data["patient_info"]["HIN"] = Modules::run('patient/print_hin',$data["patient_info"]["HIN"]);
		$data["doctor_list"] = $this->mpersistent->table_select("
		SELECT UID,CONCAT(Title,FirstName,' ',OtherName ) as Doctor 
		FROM user WHERE (Active = TRUE) AND ((Post = 'OPD Doctor') OR (Post = 'Consultant'))
		");		
		
		$data["ward_list"] = $this->mpersistent->table_select("
		SELECT WID,Name  as Ward 
		FROM ward WHERE (Active = TRUE)
		 ORDER BY Name 
		");

		$data["PID"] = $data["opd_visits_info"]["PID"];
		$data["OPDID"] = $opdid;
		
		$this->load->vars($data);
        $this->load->view('admission_proceed');		
	}	
	public function new_reffer(){
		$data = array();
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("Doctor", "Doctor", "numeric|required");
        $this->form_validation->set_rules("PID", "PID", "numeric|required");
        $this->form_validation->set_rules("Ward", "Ward", "numeric|required");
        $this->form_validation->set_rules("referred_id", "referred_id", "numeric|required");

        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
            echo Modules::run('admission/proceed',$this->input->post("referred_id") );
        } else {	
			$sve_data = array(
                'PID' => $this->input->post("PID"),
                'BHT'  => $this->input->post("BHT"),
                'AdmissionDate' => strtoupper($this->input->post("AdmissionDate")),
                'OnSetDate' => strtoupper($this->input->post("OnSetDate")),
                'Doctor' => $this->input->post("Doctor"),
                'referred_id' => $this->input->post("referred_id"),
                'referred_from' => $this->input->post("referred_from"),
                'is_referred' => $this->input->post("is_referred"),
                'Ward' => $this->input->post("Ward"),
				
                'Remarks' => $this->input->post("Remarks") ,
                'Complaint'=> $this->input->post("Complaint")
            );
			 $status = $this->mpersistent->create("admission", $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'OPD Refered'
                );
				if ( $status>0){
					//echo Modules::run($form["NEXT"], $status);
					$status1 = $this->mpersistent->update('hospital','HID' , $this->session->userdata("HID"), array("Current_BHT"=>$this->input->post("BHT")));
					$status2 = $this->mpersistent->update('opd_visits','OPDID' , $this->input->post("referred_id"), array("is_refered"=>0,"referred_admission_id"=>$status));
					header("Status: 200");
					header("Location: ".site_url('admission/view/'.$status));
					return;
				}
		}
	}
public function save_transfer(){
		$data = array();
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->load->model("madmission");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("TransferDate", "DischargeDate", "required");
       $this->form_validation->set_rules("TransferTo", "TransferTo", "numeric|required");
		$admission = $this->madmission->get_info($this->input->post("ADMID"));
        if ($this->form_validation->run() == FALSE) {
			//open_id($id=NULL,$table=null,$key_field=null)
		    $this->load->vars($data);
			header("Status: 200");
			header("Location: ".site_url('/form/create/admission_transfer/'.$this->input->post("ADMID").'/'.$admission["Ward"]));
            //Modules::run('form/edit/admission_transfer/',$this->input->post("ADMID") );
        } else {	
			$sve_data = array(
                'TransferDate'  => $this->input->post("TransferDate"),
                'TransferTo' => $this->input->post("TransferTo"),
                'TransferFrom' => $admission["WID"] ,
                'ADMID' => $this->input->post("ADMID")
            );
			//update($table=null,$key_field=null,$id=null,$data)
			 $status = $this->mpersistent->create("admission_transfer",$sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'Patient transfered'
                );
				if ( $status>0){
					$status = $this->mpersistent->update("admission","ADMID",$this->input->post("ADMID"),array("Ward"=>$this->input->post("TransferTo")));
					header("Status: 200");
					header("Location: ".site_url('admission/view/'.$this->input->post("ADMID")));
					return;
				}
		}		
	}
	public function discharge(){
		$data = array();
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("DischargeDate", "DischargeDate", "required");
        $this->form_validation->set_rules("Discharge_Doctor", "Discharge_Doctor", "numeric|required");
        $this->form_validation->set_rules("OutCome", "OutCome", "required");

        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
			header("Status: 200");
			header("Location: ".site_url('/form/edit/admission_discharge/'.$this->input->post("ADMID")));
            //echo Modules::run('form/edit/admission_discharge/',$this->input->post("ADMID") );
        } else {	
			$sve_data = array(
                'DischargeDate'  => $this->input->post("DischargeDate"),
                'Discharge_Doctor' => $this->input->post("Discharge_Doctor"),
                'OutCome' => $this->input->post("OutCome")
            );
			//update($table=null,$key_field=null,$id=null,$data)
			 $status = $this->mpersistent->update("admission","ADMID",$this->input->post("ADMID"), $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'Admission discharged'
                );
				if ( $status>0){
					header("Status: 200");
					header("Location: ".site_url('admission/view/'.$this->input->post("ADMID")));
					return;
				}
		}	
	}
    public function save()
    {
        $frm = 'admission';
        if (!file_exists('application/forms/' . $frm . '.php')) {
            die("Form " . $frm . "  not found");
        }
        include 'application/forms/' . $frm . '.php';
        $data["form"] = $form;
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        for ($i = 0; $i < count($form["FLD"]); ++$i) {
            $this->form_validation->set_rules(
                $form["FLD"][$i]["name"], '"' . $form["FLD"][$i]["label"] . '"', $form["FLD"][$i]["rules"]
            );
        }
        $this->form_validation->set_rules($form["OBJID"]);

        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
            echo Modules::run('form/create', 'admission');
        } else {
            $sve_data = array(
                'PID' => $this->input->post("PID"),
                'BHT'  => $this->input->post("BHT"),
                'AdmissionDate' => strtoupper($this->input->post("AdmissionDate")),
                'OnSetDate' => strtoupper($this->input->post("OnSetDate")),
                'Doctor' => $this->input->post("Doctor"),
                'Ward' => $this->input->post("Ward"),
                'Remarks' => $this->input->post("Remarks"),
                'Complaint'=> $this->input->post("Complaint")
            );
            $id = $this->input->post($form["OBJID"]);
            $status = false;
			
            if ($id > 0) {
                $status = $this->mpersistent->update($frm, $form["OBJID"], $id, $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . ucfirst(strtolower($this->input->post("Full_Name_Registered"))) . ' Updated'
                );
				if ( $status){
					header("Status: 200");
					header("Location: ".site_url($form["NEXT"].'/'.$id));
				}
            } else {
                $status = $this->mpersistent->create($frm, $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'Addmission created'
                );
				if ( $status>0){
					//echo Modules::run($form["NEXT"], $status);
					$status1 = $this->mpersistent->update('hospital','HID' , $this->session->userdata("HID"), array("Current_BHT"=>$this->input->post("BHT")));
					header("Status: 200");
					header("Location: ".site_url($form["NEXT"].'/'.$status));
					return;
				}
            }
            echo "ERROR in saving";
        }
    }
	public function dispence_data($pitem_id){
	$this->load->model('madmission');
	return $this->madmission->dispence_data($pitem_id);

	}
	public function update_status($sts=null,$pitem_id){
		//echo $sts.'--'.$pitem_id;
		if(!isset($sts) ||(!is_numeric($pitem_id) )){
			echo 0;
		}
		$this->load->model('mpersistent');
		$pres_item_data = array(
		'Status'    => $sts
		);
		echo $this->mpersistent->update("admission_prescribe_items", "prescribe_items_id",$pitem_id,$pres_item_data);		
	}
	
	public function update_only_once(){
		//print_r($_POST);
		//return;
		$this->load->model('mpersistent');
		$pres_item_data = array(
		'is_given'    => $_POST["is_given"],
		'given_date_time'    => $_POST["given_date"].' '.$_POST["given_time"],
		'given_by'    => $this->session->userdata("UID")
		);
		echo $this->mpersistent->update("admission_prescribe_items", "prescribe_items_id",$_POST["prescribe_items_id"],$pres_item_data);		
	}
	
	public function update_only_required(){
		//print_r($_POST);
		//return;
		$this->load->model('mpersistent');
		$pres_item_dispense_data = array(
		'prescribe_items_id'    => $_POST["prescribe_items_id"],
		'given_date_time'    => $_POST["given_date"].' '.$_POST["given_time"],
		'given_by'    => $this->session->userdata("UID")
		);
		echo $this->mpersistent->create("admission_prescribe_items_dispense", $pres_item_dispense_data);		
	}
	
	public function get_nursing_notes($admid,$continue,$mode='HTML'){
		$this->load->model("madmission");
		$data = array();
		$data["nursing_notes_list"] = $this->madmission->get_notes_list($admid);
		$data["continue"] = $continue;
		if ($mode == "HTML"){
			$this->load->vars($data);
			$this->load->view('admission_nursing_notes');
		}
		else{
			return $data["nursing_notes_list"];
		}
	}		
		
	
	public function view($admid){
		$data = array();
		if(!isset($admid) ||(!is_numeric($admid) )){
			$data["error"] = "Admission visit not found";
			$this->load->vars($data);
			$this->load->view('admission_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('madmission');
		$this->load->model('mpatient');
		$data["admission_drug_order"]  = null;
		$data["admission_drug_list"]  = null;
        $data["admission_info"] = $this->madmission->get_info($admid);
		$data["admission_lab_order_list"] = $this->madmission->get_lab_order_list($data["admission_info"]["ADMID"]);
		$data["admission_diagnosis"] = $this->madmission->get_diagnosis_list($data["admission_info"]["ADMID"]);
		$data["admission_drug_order"] = $this->madmission->get_drug_order($data["admission_info"]["ADMID"]);
		if (isset($data["admission_drug_order"]["admission_prescription_id"])){
			$data["admission_drug_list"] = $this->madmission->get_drug_order_list($data["admission_drug_order"]["admission_prescription_id"]);
		}

		if ($data["admission_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["admission_info"]["PID"], "patient", "PID");
			$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["admission_info"]["PID"]);
		}
		else{
			$data["error"] = "Admission Patient  not found";
			$this->load->vars($data);
			$this->load->view('admission_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="Admission Patient not found";
			$this->load->vars($data);
			$this->load->view('admission_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		$data["PID"] = $data["admission_info"]["PID"];
		$data["ADMID"] = $admid;
		
		$this->load->vars($data);
        $this->load->view('admission_view');	
	}
	public function new_prescribe($admid){
		if(!isset($admid) ||(!is_numeric($admid) )){
			$data["error"] = "Admission not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('madmission');
		$this->load->model('mpatient');
        $data["admission_info"] = $this->madmission->get_info($admid);
	    $data["stock_list"] = $this->madmission->get_stock_list();
		if ($data["admission_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["admission_info"]["PID"], "patient", "PID");
			$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["admission_info"]["PID"]);
		}
		else{
			$data["error"] = "Admission Patient  not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="Admission Patient not found";
			$this->load->vars($data);
			$this->load->view('opd_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		$data["user_info"] = $this->mpersistent->open_id($this->session->userdata("UID"), "user", "UID");
		//$data["my_favour"] = $this->mopd->get_favour_drug_count($this->session->userdata("UID"));
		$data["PID"] = $data["admission_info"]["PID"];
		$data["admid"] = $admid;
		$this->load->vars($data);
        $this->load->view('admission_new_prescribe');	
	}	

	public function save_prescription(){
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');

        $this->form_validation->set_rules("ADMID", "ADMID", "numeric|xss_clean");
        $this->form_validation->set_rules("PID", "PID", "numeric|xss_clean");
		$data = array();
		//Array ( [PRSID] => [CONTINUE] => admission/view/164 [ADMID] => 164 [PID] => 187 [wd_id] => 42 [Frequency] => bd [Dose] => 1 
		//HowLong] => For 5 days [drug_stock_id] => [choose_method] => by_group )
        if ($this->form_validation->run() == FALSE) {
            $data["error"] = "Save not success";
			$this->load->vars($data);
			$this->load->view('admission_error');	
			return;
        } else {	
			if($this->input->post("PRSID")>0){
				$this->add_durg_item();
				return;
			}
			 $pres_data = array(
                'Dept'   => "ADM",
                'ADMID'  => $this->input->post("ADMID"),
                'PID'    => $this->input->post("PID"),
                'PrescribeDate' => date("Y-m-d H:i:s"),
                'PrescribeBy'   => $this->session->userdata("FullName"),
                'Status'        => "Open",
                'Active'        => 1,
                'GetFrom'       => $this->input->post("drug_stock_id")
            );
			$admission_prescription_id = $this->mpersistent->create("admission_prescription", $pres_data);
			if ( $admission_prescription_id >0){
				$pres_item_data = array(
					'admission_prescription_id'   => $admission_prescription_id ,
					'DRGID'     => $this->input->post("wd_id"),
					'HowLong'   => $this->input->post("HowLong"),
					'Frequency' => $this->input->post("Frequency"),
					'Dosage'    => $this->input->post("Dose"),
					'type'    => $this->input->post("d_type"),
					'Status'    => "Continue",
					'drug_list' => "who_drug",
					'Active'    => 1
				);
				$prescribe_items_id = $this->mpersistent->create("admission_prescribe_items", $pres_item_data);
				if ( $prescribe_items_id >0){
					//echo Modules::run('opd/new_prescribe',$this->input->post("OPDID"));
					$this->session->set_flashdata('msg', 'Prescription created!' );
					if ($this->input->post("choose_method")){
						$this->mpersistent->update("user", "UID",$this->session->userdata("UID"),array("last_prescription_cmd"=>$this->input->post("choose_method")));
					}
					$this->session->set_userdata("choose_method",$this->input->post("choose_method"));
					$new_page   =   base_url()."index.php/admission/prescription/".$admission_prescription_id."?CONTINUE=".$this->input->post("CONTINUE")."";
					header("Status: 200");
					header("Location: ".$new_page);
				}
			}
			else{
				$data["error"] = "Save not complete";
				$this->load->vars($data);
				$this->load->view('admission_error');	
				return;
			}
		}		
	}
	
	public function drug_chart($prisid,$d_type="Once%20only"){
		if(!isset($prisid) ||(!is_numeric($prisid) )){
			$data["error"] = "Prescription  not found";
			$this->load->vars($data);
			$this->load->view('admission_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('madmission');
		$this->load->model('mpatient');
		$this->load->helper('string');
        $data['prisid']=$prisid;
		$data["admission_presciption_info"] = $this->mpersistent->open_id($prisid, "admission_prescription", "admission_prescription_id");
		$data["prescribe_items_list"] =$this->madmission->get_prescribe_items($prisid,urldecode($d_type));
		if(isset($data["prescribe_items_list"])){
			for ($i=0;$i<count($data["prescribe_items_list"]); ++$i){
				if ($data["prescribe_items_list"][$i]["drug_list"] == "who_drug"){
					$drug_info = $this->mpersistent->open_id($data["prescribe_items_list"][$i]["DRGID"], "who_drug", "wd_id");
					
				}	
				$data["prescribe_items_list"][$i]["drug_name"] = isset($drug_info["name"])?$drug_info["name"]:'';
				$data["prescribe_items_list"][$i]["drug_dose"] = isset($drug_info["dose"])?$drug_info["dose"]:'';
				if ($data["prescribe_items_list"][$i]["type"] == "Once only"){
					$data["prescribe_items_list"][$i]["d_type_id"] = "once_only";
				}
				else if($data["prescribe_items_list"][$i]["type"] == "Regular"){
					$data["prescribe_items_list"][$i]["d_type_id"] = "regular";
				}
				else{
					$data["prescribe_items_list"][$i]["d_type_id"] = "as_needed";
				}
			}
		}
		$data["user_info"] = $this->mpersistent->open_id($this->session->userdata("UID"), "user", "UID");
		if ($data["admission_presciption_info"]["ADMID"]>0){
			$data["admission_info"] = $this->madmission->get_info($data["admission_presciption_info"]["ADMID"]);
		}
		if ($data["admission_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["admission_info"]["PID"], "patient", "PID");
			$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["admission_info"]["PID"]);
		}
		else{
			$data["error"] = " Patient  not found";
			$this->load->vars($data);
			$this->load->view('admission_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] =" Patient not found";
			$this->load->vars($data);
			$this->load->view('admission_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		$data["PID"] = $data["admission_info"]["PID"];
		$data["ADMID"] = $data["admission_presciption_info"]["ADMID"];
		$data["d_type"] = $d_type;
		$this->load->vars($data);
		if (urldecode($d_type) == "Once only"){
			$this->load->view('admission_drug_chart');			
		}
		else if (urldecode($d_type) == "Regular"){
			$this->load->view('admission_drug_chart_regular');			
		}
		else{
			$this->load->view('admission_drug_chart_as_needed');			
		}
	}

	
	public function prescription($prisid){
		if(!isset($prisid) ||(!is_numeric($prisid) )){
			$data["error"] = "Prescription  not found";
			$this->load->vars($data);
			$this->load->view('admission_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('madmission');
		$this->load->model('mopd');
		$this->load->model('mpatient');
		$this->load->helper('string');
        $data['prisid']=$prisid;
		$data["stock_list"] = $this->madmission->get_stock_list();
		$data["admission_presciption_info"] = $this->mpersistent->open_id($prisid, "admission_prescription", "admission_prescription_id");
		$data["prescribe_items_list"] =$this->madmission->get_prescribe_items($prisid);
		if(isset($data["prescribe_items_list"])){
			for ($i=0;$i<count($data["prescribe_items_list"]); ++$i){
				if ($data["prescribe_items_list"][$i]["drug_list"] == "who_drug"){
					$drug_info = $this->mpersistent->open_id($data["prescribe_items_list"][$i]["DRGID"], "who_drug", "wd_id");
					
				}	
				$data["prescribe_items_list"][$i]["drug_name"] = isset($drug_info["name"])?$drug_info["name"]:'';
			}
		}
		$data["my_favour"] = $this->mopd->get_favour_drug_count($this->session->userdata("UID"));
		$data["user_info"] = $this->mpersistent->open_id($this->session->userdata("UID"), "user", "UID");
		if ($data["admission_presciption_info"]["ADMID"]>0){
			$data["admission_info"] = $this->madmission->get_info($data["admission_presciption_info"]["ADMID"]);
		}
		if ($data["admission_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["admission_info"]["PID"], "patient", "PID");
			$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["admission_info"]["PID"]);
		}
		else{
			$data["error"] = " Patient  not found";
			$this->load->vars($data);
			$this->load->view('admission_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] =" Patient not found";
			$this->load->vars($data);
			$this->load->view('admission_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		$data["PID"] = $data["admission_info"]["PID"];
		$data["ADMID"] = $data["admission_presciption_info"]["ADMID"];
		$this->load->vars($data);
        $this->load->view('admission_new_prescribe');			
	}
	
	
	public function add_durg_item(){
		//print_r($_POST);
		if ($_POST["PRSID"]>0){
			$pres_item_data = array(
					'admission_prescription_id'   => $this->input->post("PRSID") ,
					'DRGID'     => $this->input->post("wd_id"),
					'HowLong'   => $this->input->post("HowLong"),
					'Frequency' => $this->input->post("Frequency"),
					'Dosage'    => $this->input->post("Dose"),
					'type'    => $this->input->post("d_type"),
					'Status'    => "Continue",
					'drug_list' => "who_drug",
					'Active'    => 1
				);
			$prescribe_items_id = $this->mpersistent->create("admission_prescribe_items", $pres_item_data);
			if ( $prescribe_items_id >0){
				//echo Modules::run('opd/new_prescribe',$this->input->post("OPDID"));
				$this->session->set_flashdata('msg', 'Drug added!' );
				//($table=null,$key_field=null,$id=null,$data)
				
				if ($this->input->post("choose_method")){
					$this->mpersistent->update("user", "UID",$this->session->userdata("UID"),array("last_prescription_cmd"=>$this->input->post("choose_method")));
				}
				$this->session->set_userdata("choose_method",$this->input->post("choose_method"));
				$new_page   =   base_url()."index.php/admission/prescription/".$_POST["PRSID"]."?CONTINUE=".$this->input->post("CONTINUE")."";
				header("Status: 200");
				header("Location: ".$new_page);
			}
		}
	}
	
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */