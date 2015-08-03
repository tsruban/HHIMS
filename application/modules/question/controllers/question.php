<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends MX_Controller {

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
		$this->loadMDSPager('qu_question_repos'); 
	}
	
	public function load($fName){
		$this->loadMDSPager($fName); 
	}
	
	public function search($group=null){
       $path='application/forms/qu_question_repos.php';
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

        $this->mpager->setRowid($frm["ROW_ID"]);
        foreach ($frm["COLUMN_MODEL"] as $columnName => $model) {
            if (gettype($model) == "array") {
                $this->mpager->setColOption($columnName, $model);
            }
        }
        $action = "opener.add_question();";
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
                opener.add_question(rowId);
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
        $data["pre_page"] = "qu_question_repos";
        $this->load->vars($data);
		$this->load->view('question_search');
//        return "<h1>$sql";		
	}
	
	public function view($id=null){
		if (!Modules::run('security/check_view_access','qu_question_repos','can_view')){
			$data["error"] =" User group '".$this->session->userdata('UserGroup')."' have no rights to view this data";
			$this->load->vars($data);
			$this->load->view('question_error');
			exit;
		}
		$data = array();
		$this->load->database();
		$this->load->model("mpersistent");
		$this->load->model("mquestionnaire");
		$data['question_info'] = $this->mpersistent->open_id($id,"qu_question_repos","qu_question_repos_id");
		if (empty($data['question_info'])){ 
			$data['error'] = "Question not found";
			$this->load->vars($data);
			$this->load->view('question_view');
			return;
		}
		if ($data['question_info']['question_type'] == "Select"){
			$data['select'.$data['question_info']['qu_question_repos_id']] = $this->mquestionnaire->get_select_data($data['question_info']['qu_question_repos_id']);
		}
		if ($data['question_info']['question_type'] == "MultiSelect"){
			$data['select'.$data['question_info']['qu_question_repos_id']] = $this->mquestionnaire->get_select_data($data['question_info']['qu_question_repos_id']);
		}
		if ($data['question_info']['question_type'] == "PAIN_DIAGRAM"){
			$data['pain_diagram_info'] = $this->mquestionnaire->get_diagram_info($data['question_info']['qu_question_repos_id']);
			if (!empty($data['pain_diagram_info'])){ 
				$data['clinic_diagram_info'] = $this->mpersistent->open_id($data['pain_diagram_info']["cln_diagram_id"],"clinic_diagram","clinic_diagram_id");
			}
		}
		$this->load->vars($data);
		$this->load->view('question_view');
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
		$this->load->view('question');
//        return "<h1>$sql";
    }	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */