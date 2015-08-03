<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diagram extends MX_Controller {

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
		$this->loadMDSPager('clinic_diagram'); 
	}
	
	public function load($fName){
		$this->loadMDSPager($fName); 
	}

	public function save(){
		//print_r($_POST);
		//print_r($_FILES);
		//exit;
		if (!$_POST){
			echo "Wrong Data Try again";
			exit;
		}
		$config = $this->config->item('diagram');
		if(!is_dir($config["diagram_path"])){
			mkdir($config["diagram_path"],0755,TRUE);
		} 
		$this->load->library('upload',$config);
		$this->load->helper('form');
        $this->load->library('form_validation');
		$this->load->model("mpersistent");
		$this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("diagram_type", "diagram_type", "required");
        $this->form_validation->set_rules("name", "name", "required");
		if ( ! $this->upload->do_upload("diagram_name"))
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
			print_r($config);
			exit;
			header("Status: 200");
			header("Location: ".site_url('/form/create/clinic_diagram/1'));		
		}
		else
		{
			if ($this->form_validation->run() == FALSE) {
				header("Status: 200");
				header("Location: ".site_url('/form/create/clinic_diagram/2'));
			}
			else{
				$data = array('upload_data' => $this->upload->data());
				$save_data = array(
					"diagram_name" => $data["upload_data"]["orig_name"],
					"height" => $data["upload_data"]["image_height"],
					"width" => $data["upload_data"]["image_width"],
					"diagram_hash" => md5($data["upload_data"]["raw_name"]),
					"diagram_link" => $config["upload_path"].$data["upload_data"]["file_name"],
					"diagram_type" =>$this->input->post("diagram_type"),
					"name" =>$this->input->post("name"),
					"description" =>$this->input->post("description")
				);
				$status = $this->mpersistent->create("clinic_diagram",$save_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'File Attached'
                );
				if ( $status>0){
					header("Status: 200");
					header("Location: ".site_url('diagram'));
					return;
				}
			}
		}
	}	

	public function view($id=null,$pid=null,$mode=null,$ans_id=null){
		if (!Modules::run('security/check_view_access','clinic_diagram','can_view')){
			$data["error"] =" User group '".$this->session->userdata('UserGroup')."' have no rights to view this data";
			$this->load->vars($data);
			$this->load->view('question_error');
			exit;
		}
		$data = array();
		$this->load->database();
		$this->load->model("mpersistent");
		$data['diagram_info'] = $this->mpersistent->open_id($id,"clinic_diagram","clinic_diagram_id");
		if ($pid){
			$data["patient"] = $this->mpersistent->open_id($pid,"patient","PID");
			if (isset($data["patient"]["DateOfBirth"])) {
				$data["patient"]["Age"] = Modules::run('patient/get_age',$data["patient"]["DateOfBirth"]);
			}
		}
		if ($ans_id){
			$data["answer"] = $this->mpersistent->open_id($ans_id,"qu_answer","qu_answer_id");
		}
		$data['mode'] = $mode;
		if (empty($data['diagram_info'])){ 
			$data['error'] = "Diagram not found";
			$this->load->vars($data);
			$this->load->view('question_view');
			return;
		}

		$this->load->vars($data);
		
		$this->load->view('diagram_view');
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
		$this->load->view('diagram');
//        return "<h1>$sql";
    }	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */