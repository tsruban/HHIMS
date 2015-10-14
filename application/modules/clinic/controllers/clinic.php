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
class Clinic extends MX_Controller {
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
		return;
	}
	
	public function patient(){
       $qry = "SELECT clinic_patient.PID as PID, clinic_patient.clinic_patient_id,
	   patient.Full_Name_Registered, 
	   patient.Personal_Used_Name, 
	   clinic.name as clinic_name, 
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
        $visit_page->setShowPager(false);
        $visit_page->setColNames(array("","ID", "Patient","Title", "Next visit date","Clinic "));
        $visit_page->setRowNum(25);
        $visit_page->setColOption("PID", array("search" => false, "hidden" => true));
        $visit_page->setColOption("clinic_patient_id", array("search" => false, "hidden" => true));
        $visit_page->setColOption("Full_Name_Registered", array("search" => true, "hidden" => false));
        $visit_page->setColOption("Personal_Used_Name", array("search" => true, "hidden" => false));
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
            window.location='".site_url("/clinic/open")."/'+rowId;
        });
        }";
        $visit_page->setOrientation_EL("L");
		$data['pager'] = $visit_page->render(false);
		$this->load->vars($data);
        $this->load->view('search/clinic_search');	
       
	}	
	public function create($pid){
		$data = array();
		$this->load->vars($data);
        $this->load->view('opd_new');	
	}

	public function reffer_to_admission($opdid){
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
        $this->load->view('opd_reffer_admission');		
	}
	
	public function new_visit($clinic_patient_id){
		$this->open($clinic_patient_id,null,"NEW");
	}
	
	public function close($clinic_patient_id,$pid){
		$data = array();
		if(!isset($clinic_patient_id) ||(!is_numeric($clinic_patient_id) )){
			$data["error"] = "Clinic visit not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');	
			return;
		}
		if(!isset($pid) ||(!is_numeric($pid) )){
			$data["error"] = "Patient not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');	
			return;
		}
		$this->load->model('mpersistent');
		$st=$this->mpersistent->update("clinic_patient", "clinic_patient_id",$clinic_patient_id,array("status"=>"Closed"));
		if ( $st >0){
					//echo Modules::run('opd/new_prescribe',$this->input->post("OPDID"));
					$this->session->set_flashdata('msg', 'Clinic closed!' );
					$new_page   =   base_url()."index.php/patient/clinic/".$pid;
					header("Status: 200");
					header("Location: ".$new_page);
				}
	}
	
	public function open($clinic_patient_id,$pid=null,$ops=null){
		$data = array();
		if(!isset($clinic_patient_id) ||(!is_numeric($clinic_patient_id) )){
			$data["error"] = "Clinic visit not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mclinic');
		$this->load->model('mpatient');
		$this->load->model('mquestionnaire');
        $data["clinic_patient_info"] = $this->mpersistent->open_id($clinic_patient_id,"clinic_patient", "clinic_patient_id");
		if (empty($data["clinic_patient_info"])){
			$data["error"] ="clinic_patient_info  not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');
			return;
		}
		
        $data["clinic_info"] = $this->mpersistent->open_id($data["clinic_patient_info"]["clinic_id"],"clinic", "clinic_id");
		if (empty($data["clinic_info"])){
			$data["error"] ="clinic_info  not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');
			return;
		}
		if(!$pid){
			$pid = $data["clinic_patient_info"]["PID"];
		}
		if (isset($pid)){
			$data["patient_info"] = $this->mpersistent->open_id($pid, "patient", "PID");
			//$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($pid);
			//$data["patient_exams_list"] = $this->mpatient->get_exams_list($pid);
			//$data["patient_history_list"] = $this->mpatient->get_history_list($pid);
			//$data["patient_lab_order_list"] = $this->mpatient->get_lab_order_list($pid);
		}
		else{
			$data["error"] = "Clinic Patient  not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="Clinic Patient not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		$data["patient_info"]["HIN"] = Modules::run('patient/print_hin',$data["patient_info"]["HIN"]);
		$data["clinic_questionnaire_list"] = null;
		//$data["clinic_questionnaire_list"] = $this->mquestionnaire->get_questionnaire_list("patient");
		$data["clinic_questionnaire_list"] = $this->mquestionnaire->get_clinic_questionnaire_list($data["clinic_info"]["clinic_id"]);
		$data["clinic_previous_record_list"] = $this->mquestionnaire->get_clinic_previous_record_list($clinic_patient_id,1,10);
		if (!empty($data["clinic_previous_record_list"])){
			for($i=0;$i<count($data["clinic_previous_record_list"]);++$i){
				$data["clinic_previous_record_list"][$i]["data"] = $this->mquestionnaire->get_clinic_patient_answer_list($data["clinic_previous_record_list"][$i]["qu_quest_answer_id"]);
				if (!empty($data["clinic_previous_record_list"][$i]["data"])){
					for($j=0;$j<count($data["clinic_previous_record_list"][$i]["data"]);++$j){
						if ($data["clinic_previous_record_list"][$i]["data"][$j]["question_type"] == "Select"){ //answer type select
							$ans = $this->mpersistent->open_id($data["clinic_previous_record_list"][$i]["data"][$j]["answer"],"qu_select", "qu_select_id");
							if (isset($ans["select_text"])){
								$data["clinic_previous_record_list"][$i]["data"][$j]["answer"] = $ans["select_text"];
							}
							else {
								$data["clinic_previous_record_list"][$i]["data"][$j]["answer"] = '';
							}
						}
						if ($data["clinic_previous_record_list"][$i]["data"][$j]["question_type"] == "MultiSelect"){ //answer type multi-select
							$user_answeres = explode(",", $data["clinic_previous_record_list"][$i]["data"][$j]["answer"]);
							
							$output_answer = '';
							for ($ua=0; $ua < count($user_answeres); ++$ua){
								if ($user_answeres[$ua] >0){
									$ans = $this->mpersistent->open_id($user_answeres[$ua],"qu_select", "qu_select_id");
									$output_answer .=$ans["select_text"].', ';
								}
							}
							if (isset($output_answer)){
								$data["clinic_previous_record_list"][$i]["data"][$j]["answer"] =$output_answer;
							}
							else {
								$data["clinic_previous_record_list"][$i]["data"][$j]["answer"] = '';
							}
						}
						
						if ($data["clinic_previous_record_list"][$i]["data"][$j]["question_type"] == "PAIN_DIAGRAM"){
							$data['pain_diagram_info'] = $this->mquestionnaire->get_diagram_info($data["clinic_previous_record_list"][$i]["data"][$j]["qu_question_id"]);
							if (!empty($data['pain_diagram_info'])){ 
								$data['clinic_diagram_info'] = $this->mpersistent->open_id($data['pain_diagram_info']["cln_diagram_id"],"clinic_diagram","clinic_diagram_id");
							}
						}
					}
				}
			}
		}
		$data["pid"] = $pid;
		$data["clinic_id"] = $data["clinic_patient_info"]["clinic_id"];
		$data["clinic_patient_id"] = $clinic_patient_id;
		
		$this->load->vars($data);
		if ($ops == "NEW"){
			$this->load->view('clinic_new');	
		}
		else{
		    $this->load->view('clinic_view');	
		}	
	}

public function save_prescription(){
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');

        $this->form_validation->set_rules("clinic_patient_id", "clinic_patient_id", "numeric|xss_clean");
        $this->form_validation->set_rules("PID", "PID", "numeric|xss_clean");
        $this->form_validation->set_rules("wd_id", "Age", "numeric|xss_clean");
		$data = array();
		//Array ( [clinic_prescription_id] => [CONTINUE] => clinic/open/27 [clinic_patient_id] => 27 [PID] => 187 [Frequency] => tds [Dose] => 2/3 [HowLong] => For 4 days [drug_stock_id] => 2 [choose_method] => by_name )
		//print_r($_POST);
		//exit;
        if ($this->form_validation->run() == FALSE) {
            $data["error"] = "Save not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');	
			return;
        } else {	
			if($this->input->post("clinic_prescription_id")>0){
				$this->add_durg_item();
				return;
			}
			 $pres_data = array(
                'Dept'   => "CLN",
                'clinic_patient_id'  => $this->input->post("clinic_patient_id"),
                'PID'    => $this->input->post("PID"),
                'PrescribeDate'   => date("Y-m-d H:i:s"),
                'PrescribeBy' => $this->session->userdata("FullName"),
                'Status'      => "Draft",
                'Active'      => 1
            );
			$clinic_prescription_id = $this->mpersistent->create("clinic_prescription", $pres_data);
			if ( $clinic_prescription_id >0){
				$pres_item_data = array(
					'clinic_prescription_id'        => $clinic_prescription_id ,
					'DRGID'  => $this->input->post("wd_id"),
					'HowLong'    => $this->input->post("HowLong"),
					'Frequency'    => $this->input->post("Frequency"),
					'Dosage'    => $this->input->post("Dose"),
					'Status'           => "Pending",
					'Active'                   => 1
				);
				$clinic_prescribe_item_id = $this->mpersistent->create("clinic_prescribe_items", $pres_item_data);
				if ( $clinic_prescribe_item_id >0){
					//echo Modules::run('opd/new_prescribe',$this->input->post("OPDID"));
					$this->session->set_flashdata('msg', 'Prescription created!' );
					$new_page   =   base_url()."index.php/clinic/prescription/".$clinic_prescription_id."?CONTINUE=".$this->input->post("CONTINUE")."";
					header("Status: 200");
					header("Location: ".$new_page);
				}
			}
			else{
				$data["error"] = "Save not found";
				$this->load->vars($data);
				$this->load->view('clinic_error');	
				return;
			}
		}		
	}



	public function prescription($clinic_prescription_id){
		if(!isset($clinic_prescription_id) ||(!is_numeric($clinic_prescription_id) )){
			$data["error"] = "Prescription  not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mopd');
		$this->load->model('mclinic');
		$this->load->model('mpatient');
		$this->load->helper('string');
        $data['clinic_prescription_id']=$clinic_prescription_id;
		$data["clinic_presciption_info"] = $this->mpersistent->open_id($clinic_prescription_id, "clinic_prescription", "clinic_prescription_id");
		$data["clinic_patient_info"] = $this->mpersistent->open_id($data["clinic_presciption_info"]["clinic_patient_id"] , "clinic_patient", "clinic_patient_id");
		$data["prescribe_items_list"] =$this->mclinic->get_prescribe_items($clinic_prescription_id);
		if(isset($data["prescribe_items_list"])){
			for ($i=0;$i<count($data["prescribe_items_list"]); ++$i){
				$drug_info = $this->mpersistent->open_id($data["prescribe_items_list"][$i]["DRGID"], "who_drug", "wd_id");
				$data["prescribe_items_list"][$i]["drug_name"] = isset($drug_info["name"])?$drug_info["name"]:'';
			}
		}
		$data["my_favour"] = $this->mopd->get_favour_drug_count($this->session->userdata("UID"));
		$data["user_info"] = $this->mpersistent->open_id($this->session->userdata("UID"), "user", "UID");
		///if ($data["clinic_presciption_info"]["clinic_patient_id"]>0){
			//$data["clinic_presciption_info"] = $this->mopd->get_info($data["opd_presciption_info"]["OPDID"]);
		//}
		if ($data["clinic_presciption_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["clinic_presciption_info"]["PID"], "patient", "PID");
			$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["clinic_presciption_info"]["PID"]);
		}
		else{
			$data["error"] = "OPD Patient  not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="OPD Patient not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		//if(isset($data["opd_visits_info"]["visit_type_id"])){
			$data["clinic_info"] = $this->mclinic->get_clinic_info($data["clinic_patient_info"]["clinic_id"]);
			 $data["stock_info"] = $this->mpersistent->open_id($data["clinic_info"]["drug_stock"],"drug_stock", "drug_stock_id");
		//}
		$data["PID"] = $data["clinic_presciption_info"]["PID"];
		$data["clinic_patient_id"] = $data["clinic_presciption_info"]["clinic_patient_id"];
		$this->load->vars($data);
        $this->load->view('clinic_new_prescribe');			
	}
	
	public function add_durg_item(){
		//print_r($_POST);
		if ($_POST["clinic_prescription_id"]>0){
			$pres_item_data = array(
						'clinic_prescription_id'        => $_POST["clinic_prescription_id"] ,
						'DRGID'  => $this->input->post("wd_id"),
						'HowLong'    => $this->input->post("HowLong"),
						'Frequency'    => $this->input->post("Frequency"),
						'Dosage'    => $this->input->post("Dose"),
						'Status'           => "Pending",
						'Active'                   => 1
					);
			$clinic_prescribe_item_id = $this->mpersistent->create("clinic_prescribe_items", $pres_item_data);
			if ( $clinic_prescribe_item_id >0){
				//echo Modules::run('opd/new_prescribe',$this->input->post("OPDID"));
				$this->session->set_flashdata('msg', 'Drug added!' );
				//($table=null,$key_field=null,$id=null,$data)
				
				if ($this->input->post("choose_method")){
					$this->mpersistent->update("user", "UID",$this->session->userdata("UID"),array("last_prescription_cmd"=>$this->input->post("choose_method")));
				}
				$this->session->set_userdata("choose_method",$this->input->post("choose_method"));
				$new_page   =   base_url()."index.php/clinic/prescription/".$_POST["clinic_prescription_id"]."?CONTINUE=".$this->input->post("CONTINUE")."";
				header("Status: 200");
				header("Location: ".$new_page);
			}
		}
	}


	public function prescription_send($prsid){
			$this->load->model("mpersistent");
			 $pres_data = array(
                'PrescribeDate'   => date("Y-m-d H:i:s"),
                'Status'      => "Pending",
                'Active'      => 1
            );
			//update($table=null,$key_field=null,$id=null,$data)
			if( $this->mpersistent->update("clinic_prescription","clinic_prescription_id",$prsid, $pres_data) > 0 ){
				$this->session->set_flashdata('msg', 'Prescription sent!' );
				echo 1;
			}
			else{
				echo 0;
			}
	}
	
public function new_prescribe($clnid){
		if(!isset($clnid) ||(!is_numeric($clnid) )){
			$data["error"] = "OPD visit not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mclinic');
		$this->load->model('mopd');
		$this->load->model('mpatient');
		 $data["clinic_patient_info"] = $this->mpersistent->open_id($clnid,"clinic_patient", "clinic_patient_id");
		 $data["clinic_info"] = $this->mclinic->get_clinic_info($data["clinic_patient_info"]["clinic_id"]);
		 $data["stock_info"] = $this->mpersistent->open_id($data["clinic_info"]["drug_stock"],"drug_stock", "drug_stock_id");
		 if (empty($data["clinic_patient_info"])){
			$data["error"] ="clinic_patient_info  not found";
			$this->load->vars($data);
			$this->load->view('clinic_error');
			return;
		}
		//if(isset($data["opd_visits_info"]["visit_type_id"])){
			//$data["stock_info"] = $this->mopd->get_stock_info($data["opd_visits_info"]["visit_type_id"]);
		//}
		if ($data["clinic_patient_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["clinic_patient_info"]["PID"], "patient", "PID");
			$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["clinic_patient_info"]["PID"]);
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
		$data["user_info"] = $this->mpersistent->open_id($this->session->userdata("UID"), "user", "UID");
		$data["my_favour"] = $this->mopd->get_favour_drug_count($this->session->userdata("UID"));
		$data["PID"] = $data["clinic_patient_info"]["PID"];
		$data["CLNID"] = $clnid;
		$this->load->vars($data);
        $this->load->view('clinic_new_prescribe');	
	}	
	
	
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */