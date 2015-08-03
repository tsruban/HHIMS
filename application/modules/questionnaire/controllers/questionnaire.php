<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questionnaire extends MX_Controller {

	public $data = array();
	
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
        $this->load->helper('url');
         $this->load->library('session');
		//$this->load->library('MdsCore');
	 }

	public function index($pre_page=NULL)
	{
		$this->loadMDSPager('qu_questionnaire'); 
	}
	
	public function load($q_id,$pid,$link_type=null,$link_id=null){
		if (!Modules::run('security/check_view_access','questionnaire','can_create')){
			$data["error"] =" User group '".$this->session->userdata('UserGroup')."' have no rights to view this data";
			$this->load->vars($data);
			$this->load->view('questionnaire_error');
			exit;
		}		
		if (!$q_id){
			$data["error"] =" Questionnaire not valid";
			$this->load->vars($data);
			$this->load->view('questionnaire_error');
			exit;
		}
		if (!$pid){
			$data["error"] =" Patient ID not  valid";
			$this->load->vars($data);
			$this->load->view('questionnaire_error');
			exit;
		}
		$data = array();
		$this->load->database();
		$this->load->model("mquestionnaire");
		$this->load->model('mpersistent');
		$this->load->library('form_validation');
		$data['questionnaire_info'] = $this->mquestionnaire->get_questionnaire_info($q_id);
		if (empty($data['questionnaire_info'])){ 
			$data['error'] = "Questionnaire not found";
			$this->load->vars($data);
			$this->load->view('questionnaire_error');
			return;
		}
		$data['question_list'] = $this->mquestionnaire->get_question_list($q_id);
		if(isset($data['question_list']) && count($data['question_list'])){
			for($i=0; $i < count($data['question_list']); ++$i){
				if ($data['question_list'][$i]['question_type'] == "Select"){
					$data['select'.$data['question_list'][$i]['qu_question_id']] = $this->mquestionnaire->get_select_data($data['question_list'][$i]['qu_question_repos_id']);
				}
				if ($data['question_list'][$i]['question_type'] == "MultiSelect"){
					$data['mselect'.$data['question_list'][$i]['qu_question_id']] = $this->mquestionnaire->get_select_data($data['question_list'][$i]['qu_question_repos_id']);
				}
				if ($data['question_list'][$i]['question_type'] == "PAIN_DIAGRAM"){
					$data['pain_diagram_info'] = $this->mquestionnaire->get_diagram_info($data['question_list'][$i]['qu_question_repos_id']);
					if (!empty($data['pain_diagram_info'])){ 
						$data['clinic_diagram_info'] = $this->mpersistent->open_id($data['pain_diagram_info']["cln_diagram_id"],"clinic_diagram","clinic_diagram_id");
					}
				}
			}
		}

        $data["patient_info"] = $this->mpersistent->open_id($pid, "patient", "PID");
		if (empty($data["patient_info"])){
			$data["error"] ="Patient not found";
			$this->load->vars($data);
			$this->load->view('questionnaire_error');
			exit;
		}
		
		$data["mode"] = "RUN";
		$data["link_type"] = $link_type;
		$data["link_id"] = $link_id;
		$data["CONTINUE"] = null;
		if (isset($_GET["CONTINUE"])){
			$data["CONTINUE"] = $_GET["CONTINUE"];
		}
		$this->load->vars($data);
		$this->load->view('questionnaire_view');		
	}
	public function move_question(){
		$qid  = $_GET["qid"]; 
		$pos= $_GET["pos"];
		if (!$qid || !$pos){
			echo -1;
			return;
		}
		$this->load->database();
		$this->load->model("mpersistent");
		//update($table=null,$key_field=null,$id=null,$data)
		echo $this->mpersistent->update("qu_question","qu_question_id",$qid,array("show_order"=>$pos));

	}
	public function add_question(){
		$quest_id = $_GET["quest_id"]; 
		$qid= $_GET["qid"];
		if (!$quest_id || !$qid){
			echo -1;
			return;
		}
		$this->load->database();
		$this->load->model("mpersistent");
		if ($this->is_question_exsist($quest_id,$qid)){
			echo 0;
			return;
		}
		$count = $this->count_all_question($quest_id);
		echo $this->mpersistent->create("qu_question",array("qu_question_id"=>$this->get_unique_id(),"qu_questionnaire_id"=>$quest_id,"qu_question_repos_id"=>$qid,"active"=>"1","show_order"=>$count+1));
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
	function is_question_exsist($quest_id,$qid){
		$this->load->database();
		$this->load->model("mquestionnaire");
		$count =  $this->mquestionnaire->count_question($quest_id, $qid);
		if ($count>0){
			return true;
		}
		return false;
	}
			
	function count_all_question($quest_id){
		$this->load->database();
		$this->load->model("mquestionnaire");
		return $this->mquestionnaire->count_all_question($quest_id);
	}
	
	public function open($id=null){
		$data = array();
		$this->load->database();
		$this->load->model("mquestionnaire");
		$this->load->model("mpersistent");
		$this->load->library('form_validation');
		$data['questionnaire_info'] = $this->mquestionnaire->get_questionnaire_info($id);
		if (empty($data['questionnaire_info'])){ 
			$data['error'] = "Questionnaire not found";
			$this->load->vars($data);
			$this->load->view('questionnaire_error');
			return;
		}
		if ($data["questionnaire_info"]['show_in_clinic']>0){
			$data['clinic_info'] = $this->mpersistent->open_id($data["questionnaire_info"]['show_in_clinic'],"clinic","clinic_id");
		}
		if ($data["questionnaire_info"]['show_in_visit']>0){
			$data['visit_info'] = $this->mpersistent->open_id($data["questionnaire_info"]['show_in_visit'],"visit_type","VTYPID");
		}
		$data['question_list'] = $this->mquestionnaire->get_question_list($id);
		//print_r($data['question_list'] );
		if(isset($data['question_list']) && count($data['question_list'])){
			for($i=0; $i < count($data['question_list']); ++$i){
				if ($data['question_list'][$i]['question_type'] == "Select"){
					$data['select'.$data['question_list'][$i]['qu_question_id']] = $this->mquestionnaire->get_select_data($data['question_list'][$i]['qu_question_repos_id']);
				}
				if ($data['question_list'][$i]['question_type'] == "MultiSelect"){
					$data['mselect'.$data['question_list'][$i]['qu_question_id']] = $this->mquestionnaire->get_select_data($data['question_list'][$i]['qu_question_repos_id']);
				}
				if ($data['question_list'][$i]['question_type'] == "PAIN_DIAGRAM"){
					$data['pain_diagram_info'] = $this->mquestionnaire->get_diagram_info($data['question_list'][$i]['qu_question_repos_id']);
					if (!empty($data['pain_diagram_info'])){ 
						$data['clinic_diagram_info'] = $this->mpersistent->open_id($data['pain_diagram_info']["cln_diagram_id"],"clinic_diagram","clinic_diagram_id");
					}
				}
			}
		}
		//        print_r($data);
		//exit;
		$data["mode"] = "VIEW";
		$this->load->vars($data);
		$this->load->view('questionnaire_view');
	}
	public function save(){
		$this->load->database();
		$this->load->model("mquestionnaire");
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
		if ($_POST["qu_questionnaire_id"]){
			$data['question_list'] = $this->mquestionnaire->get_question_list($_POST["qu_questionnaire_id"]);
		}
		if(isset($data['question_list']) && count($data['question_list'])){
			for($i=0; $i < count($data['question_list']); ++$i){
				if ($data['question_list'][$i]['question_type'] == "Select"){
						$data['select'.$data['question_list'][$i]['qu_question_id']] = $this->mquestionnaire->get_select_data($data['question_list'][$i]['qu_question_repos_id']);
				}
				if ($data['question_list'][$i]['question_type'] != "Header"){
					if ($data['question_list'][$i]['question_type'] == "Yes_No"){
						$this->form_validation->set_rules($data['question_list'][$i]["qu_question_repos_id"], '"'.$data['question_list'][$i]["question"].'"', "xss_clean");
					}
					elseif ($data['question_list'][$i]['question_type'] == "Text"){
						$this->form_validation->set_rules($data['question_list'][$i]["qu_question_repos_id"], '"'.$data['question_list'][$i]["question"].'"', "xss_clean");
					}
					else{
						$this->form_validation->set_rules($data['question_list'][$i]["qu_question_repos_id"], '"'.$data['question_list'][$i]["question"].'"', "xss_clean");
					}
				}
			}
		}	

		$this->form_validation->set_rules("CONTINUE", "CONTINUE", "xss_clean");
		$this->form_validation->set_rules("link_id", "link_id", "xss_clean|required");
		$this->form_validation->set_rules("link_type", "link_type", "xss_clean|required");
		if ($this->form_validation->run() == FALSE){
			$this->load($_POST["qu_questionnaire_id"],$_POST["PID"],$_POST["link_type"],$_POST["link_id"]);
		}
		else{
			$this->load->model("mpersistent");
			$data['questionnaire_info'] = $this->mquestionnaire->get_questionnaire_info($_POST["qu_questionnaire_id"]);
			$qu_quest_answer_id = $this->get_unique_id();
			$sve_data = array(
			"qu_quest_answer_id"=>$qu_quest_answer_id,
			"qu_questionnaire_id"=>$_POST["qu_questionnaire_id"],
			"active"=>"1"
			);
			$sve_data["link_type"] = $_POST["link_type"];
			$sve_data["link_id"] = $_POST["link_id"];
			$res  = $this->mpersistent->create("qu_quest_answer",$sve_data);
			
			$ans_data_array = array();	
			//print_r($data['question_list'])."<br>";
			//print_r($_POST);
			//exit;
			if(isset($data['question_list']) && count($data['question_list'])){
				for($i=0; $i < count($data['question_list']); ++$i){
					//if ($data['question_list'][$i]["question_type"] == "Header") continue;
					$ans = isset($_POST[$data['question_list'][$i]['qu_question_repos_id']])?$_POST[$data['question_list'][$i]['qu_question_repos_id']]:"";
					$ans_data = array(
					"qu_answer_id"=>$this->get_unique_id(),
					"qu_quest_answer_id"=>$qu_quest_answer_id,
					"qu_question_id"=>$data['question_list'][$i]['qu_question_repos_id'],
					"answer"=>isset($_POST[$data['question_list'][$i]['qu_question_repos_id']])?$_POST[$data['question_list'][$i]['qu_question_repos_id']]:"",
					"answer_type"=>$data['question_list'][$i]['question_type'],
					"answer_order"=>$i,
					"CreateDate"=>date("Y-m-d H:i:s"),
					"CreateUser"=>$this->session->userdata("FullName"),
					"active"=>"1"
					);
					if ($ans!="")array_push($ans_data_array,$ans_data );
				}
			}
			$status = $this->mpersistent->insert_batch("qu_answer",$ans_data_array);	
			
			if (!$status){
				$data['error'] = "Questionnaire  couldnt save";
				$this->load->vars($data);
				$this->load->view('questionnaire_error');
				return;
			}
			if (isset($_POST["CONTINUE"])){
				$this->session->set_flashdata('msg', 'REC: ' . 'Questionnaire saved');
				header("Status: 200");
				header("Location: ".site_url($_POST["CONTINUE"])); 
				return;
			}
			else{
				if ($data['questionnaire_info']["show_in_patient"] == 1){
					header("Status: 200");
					header("Location: ".site_url("patient/view/".$_POST["PID"])); 
					return;
				}
			}
		}
	}
	
	public function add_option($qu_id){
		
	}
	
   private function loadMDSPager($fName) {
        $path='application/forms/' . $fName . '.php';
        require $path;
        $frm = $form;
        $columns = $frm["LIST"];
        $table = $frm["TABLE"];
        $sql = "SELECT ";

        foreach ($columns as $column) {
            $sql.=$column . ',';
        }
        $sql = substr($sql, 0, -1);
        $sql.=" FROM $table ";
        $this->load->model('mpager');
        $this->mpager->setSql($sql);
        $this->mpager->setDivId('prefCont');
        $this->mpager->setSortorder('asc');
        //set colun headings
        $colNames = array();
        foreach ($frm["DISPLAY_LIST"] as $colName) {
            array_push($colNames, $colName);
        }
        $this->mpager->setColNames($colNames);

        //set captions
        $this->mpager->setCaption($frm["CAPTION"]);
        //set row id
        $this->mpager->setRowid($frm["ROW_ID"]);

        //set column models
        foreach ($frm["COLUMN_MODEL"] as $columnName => $model) {
            if (gettype($model) == "array") {
                $this->mpager->setColOption($columnName, $model);
            }
        }

        //set actions
        $action = $frm["ACTION"];
        $this->mpager->gridComplete_JS = "function() {
            var c = null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow','cursor':'pointer'});
            }).mouseout(function(e){
                $(this).css('background',c);
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='$action'+rowId;
            });
            }";

        //report starts
        if(isset($frm["ORIENT"])){
            $this->mpager->setOrientation_EL($frm["ORIENT"]);
        }
        if(isset($frm["TITLE"])){
            $this->mpager->setTitle_EL($frm["TITLE"]);
        }

//        $pager->setSave_EL($frm["SAVE"]);
        $this->mpager->setColHeaders_EL(isset($frm["COL_HEADERS"])?$frm["COL_HEADERS"]:$frm["DISPLAY_LIST"]);
        //report endss

        $data['pager']=$this->mpager->render(false);
        $data["pre_page"] = $fName;
        $this->load->vars($data);
		$this->load->view('questionnaire');
//        return "<h1>$sql";
    }	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */