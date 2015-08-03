<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drug_stock extends MX_Controller {

	public $data = array();
	
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
        $this->load->helper('url');
         $this->load->library('session');
		//$this->load->library('MdsCore');
		$this->load->model("mdrug_stock");
	 }
	 public function index($drug_stock_id=NULL){

		return;
	 }
	 
	 private function update_stock_drug_list($drug_stock_id){
		$data['who_drug_list'] = $this->mdrug_stock->get_who_drug_list();	
		if (!empty($data['who_drug_list'])){
			for ($i=0; $i<count($data['who_drug_list']);++$i){
				if ($this->mdrug_stock->is_drug_exsist($drug_stock_id,$data['who_drug_list'][$i]["wd_id"]) == 0){
					$drug_data = array(
						"drug_stock_id"=> $drug_stock_id,
						"who_drug_id"=> $data["who_drug_list"][$i]["wd_id"],
						"who_drug_count"=>101,
						"Active"=>1
					);
					$this->load->model("mpersistent");
					$this->mpersistent->create("drug_count",$drug_data);
				}
			}
		}
		return true;
	 }
	public function add_stock(){
		$drug_count_id = $_POST["drug_count_id"]; 
		$who_drug_count= $_POST["who_drug_count"];
		if (!$who_drug_count || !$drug_count_id){
			echo -1;
			return;
		}
		$this->load->database();
		$this->load->model("mpersistent");
		//($table=null,$key_field=null,$id=null,$data)
		echo $this->mpersistent->update("drug_count","drug_count_id",$drug_count_id,array("drug_count_id"=>$drug_count_id,"who_drug_count"=>$who_drug_count,"active"=>"1"));
		
	}
	public function view($drug_stock_id=NULL)
	{			
		if (!Modules::run('security/check_view_access','drug_stock','can_view')){
			$data["error"] =" User group '".$this->session->userdata('UserGroup')."' have no rights to view this data";
			$this->load->vars($data);
			$this->load->view('drug_stock_error');
			exit;
		}	
		
		$data['drug_stock_list'] = $this->mdrug_stock->get_drug_stock_list();	
			
		if ($this->config->item('purpose') =="PP"){
			$drug_stock_id=1;
		}			
		if ($drug_stock_id){
			if ($this->update_stock_drug_list($drug_stock_id)){
				$data['drug_stock_info'] = $this->mdrug_stock->get_drug_stock_info($drug_stock_id);	
			}
		}
		
		
		$data['drug_count_list'] =$this->mdrug_stock->get_drug_count_list($drug_stock_id);
		$this->load->vars($data);
		$this->load->view('drug_stock_view');		
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
		echo $this->mpersistent->create("qu_question",array("qu_questionnaire_id"=>$quest_id,"qu_question_repos_id"=>$qid,"active"=>"1","show_order"=>$count+1));
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
		$data['questionnaire_info'] = $this->mquestionnaire->get_questionnaire_info($id);
		if (empty($data['questionnaire_info'])){ 
			$data['error'] = "Questionnaire not found";
			$this->load->vars($data);
			$this->load->view('questionnaire_error');
			return;
		}
		$data['question_list'] = $this->mquestionnaire->get_question_list($id);
		if(isset($data['question_list']) && count($data['question_list'])){
			for($i=0; $i < count($data['question_list']); ++$i){
				if ($data['question_list'][$i]['question_type'] == "Select"){
					$data['select'.$data['question_list'][$i]['qu_question_id']] = $this->mquestionnaire->get_select_data($data['question_list'][$i]['qu_question_id']);
				}
			}
		}
		$data["mode"] = "VIEW";
		$this->load->vars($data);
		$this->load->view('questionnaire_view');
	}
	public function save(){
		echo "Data Sent to server...";
	}
	public function add_ooption($qu_id){
		
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