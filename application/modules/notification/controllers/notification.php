<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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
class Notification extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checkLogin();
        $this->load->library('session');
		if(isset($_GET["mid"])){
			$this->session->set_userdata('mid', $_GET["mid"]);
		}		
    }

    public function index()
    {
        $this->notification_search();
    }
	public function save_email(){
		if($_POST){
			//($table=null,$key_field=null,$id=null,$data){
			$this->load->model("mpersistent");
			 $save_data = array(
                'TOID'   => $this->input->post("TOID"),
                'Confirmed'   => $this->input->post("Confirmed"),
                'LabConfirm'   => $this->input->post("LabConfirm"),
            );
			$notification_id = $this->mpersistent->update("notification","NOTIFICATION_ID",$this->input->post("NOTIFICATION_ID"), $save_data);
			if ($notification_id){
				$new_page   =   base_url()."index.php/notification/view/".$this->input->post("NOTIFICATION_ID");
				header("Status: 200");
				header("Location: ".$new_page);
			}			
		}
	}
	public function save(){
		if($_POST){
			$this->load->model("mpersistent");
			 $save_data = array(
                'Disease'   => $this->input->post("Disease"),
                'Episode_Type'   => $this->input->post("Episode_Type"),
                'EPISODEID'   => $this->input->post("EPISODEID"),
                'LabConfirm'   => $this->input->post("LabConfirm"),
                'Remarks'   => $this->input->post("Remarks"),
                'ConfirmedBy' => $this->session->userdata("UID"),
                'Status'      => "Pending",
                'Active'      => 1
            );
			$notification_id = $this->mpersistent->create("notification", $save_data);
			if ($notification_id){
				$this->session->set_flashdata('msg', 'Notification created!' );
				if ($this->input->post("CONTINUE")){
					$new_page   =   base_url()."index.php/".$this->input->post("CONTINUE");
				}
				else if ($this->input->post("Episode_Type") == "opd"){
					$new_page   =   base_url()."index.php/opd/view/".$this->input->post("EPISODEID");
				}
				header("Status: 200");
				header("Location: ".$new_page);
			}			
		}
	}
	
	public function edit($nid){
		$this->view($nid,"EDIT");
		
	}
	
	public function create($epicode_type,$epicode_id){
		if ((!$epicode_type)||(!is_numeric($epicode_id))){
			$data["error"] = "OPD visit not found";
			$this->load->vars($data);
			$this->load->view('notification_error');	
			return;
		}
		$this->load->helper('form');
		$data["epicode_type"] = $epicode_type;
		$data["hospital"] = $this->session->userdata('Hospital');
		if ($epicode_type=="opd"){
			$this->load->model('mopd');
			$this->load->model('mpersistent');
			$data["opd_visits_info"] = $this->mopd->get_info($epicode_id);
			$data["patient_info"] = $this->mpersistent->open_id($data["opd_visits_info"]["PID"], "patient", "PID");
			if (isset($data["patient_info"]["DateOfBirth"])) {
				$data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
			}
			$data["patient_info"]["HIN"] = Modules::run('patient/print_hin',$data["patient_info"]["HIN"]);
		}
		$this->load->vars($data);
		$this->load->view('notification_form');
	}
	
    public function notification_search()
    {
        $this->load->model('mpager');
        $pager2 = $this->mpager;
        $pager2->setSql(
            "select NOTIFICATION_ID,Episode_Type,Disease,LabConfirm,Confirmed,CreateDate,Status from notification where Active = 1"
        );
        $pager2->setDivId('prefCont'); //important
        $pager2->setDivClass('');
//        $pager2->setDivStyle('position:absolute');
        $pager2->setRowid('NOTIFICATION_ID');
//        $pager2->setHeight(400);
        $pager2->setCaption("Notification List");
        //$pager->setSortname("CreateDate");
        $pager2->setColNames(array("ID", "Department", "Disease", "Lab confirmed", "Confirmed", "Date", "Status"));
        $pager2->setColOption("NOTIFICATION_ID", array("search" => false));
        $pager2->setColOption(
            "Episode_Type",
            array("stype" => "select", "searchoptions" => array("value" => ":All;Admission:Admission;OPD:OPD"))
        );
        $pager2->setColOption(
            "LabConfirm",
            array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",
                  'stype'        => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),
            )
        );
        $pager2->setColOption(
            "Confirmed",
            array("formatter_JS" => "function(cellvalue, options, rowObject){switch(cellvalue){case '1':return 'yes';break;case '0':return 'no';break;default:return 'undefined';}}",
                  'stype'        => 'select', 'editoptions' => array('value' => ":All;1:Yes;0:No"),
            )
        );
        $pager2->setColOption(
            "Status", array("stype"         => "select",
                            "searchoptions" => array("value"        => ":All;Pending:Pending;Sent:Sent",
                                                     "defaultValue" => "Pending"))
        );
        $pager2->setColOption("CreateDate", $pager2->getDateSelector());
        $action = site_url('notification/view/') . '/';
        $pager2->gridComplete_JS
            = "function() {
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                $(this).css({'cursor':'pointer'});
            }).mouseout(function(e){
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='$action'+rowId;
            });
            }";
        $pager2->setOrientation_EL("L");
        $data['pager'] = $pager2->render(false);
        $this->load->vars($data);
        $this->load->view('notification_search');
    }

    public function view($notificationId,$mode=null)
    {
        $data = array();
        $notification = $this->load->model('mnotification');
        $notification->load($notificationId);
        $data['notification'] = $notification;
        if ($notification->getValue("Episode_Type") == 'admission') {
            $admid = $notification->getValue("EPISODEID");
            $admission = $this->load->model('madmission', 'admission');
            $admission->openId($admid);
            $data['epicode'] = $admission;
            $patient = $this->load->model('mpatient', 'patient')->load($admission->PID);
            $this->patient = $patient;
            $ward = $this->load->model('mward', 'ward')->OpenId($admission->getValue("Ward"));
            $data['ward'] = $ward;
            $doctor = $this->load->model('muser', 'doctor');
            $doctor->openId($notification->getValue("ConfirmedBy"));
            $data['epicode_type'] = "Admission";
            $data['subject']
                =
                $notification->getValue("Disease") . " in " . $patient->getValue("Address_Village") . " (NOTIFICATION)";
        } else {
            if ($notification->getValue("Episode_Type") == 'opd') {
                $opdid = $notification->getValue("EPISODEID");
                $opd = $this->load->model('mopd', 'opd');
                $opd->openId($opdid);
                $data['epicode'] = $opd;
                $data['epicode_type'] = "Opd";
                $patient = $this->load->model('mpatient', 'patient')->load($opd->PID);
                $doctor = $this->load->model('muser', 'doctor');
                $doctor->openId($notification->getValue("ConfirmedBy"));

            } else {
                echo " Episode not found";
            }
        }
        $data['doctor'] = $doctor;
        $data['mode'] = $mode;
        $data['subject']
            = $notification->getValue("Disease") . " in " . $patient->getValue("Address_Village")
            . " (NOTIFICATION)";
        $data['hospital'] = $this->load->model('mhospital', 'hospital')->load($patient->HID);
        $data['patient'] = $patient;
        if ($notification->getValue("LabConfirm") == 1) {
            $pat_lab_d = "Yes";
        } else {
            $pat_lab_d = "No";
        } 
		if ($notification->getValue("Confirmed") == 1) {
            $Confirmed = "Yes";
        } else {
            $Confirmed = "No";
        }
        $data['lab'] = $pat_lab_d;
        $data['Confirmed'] = $Confirmed;
        $data['user'] = $this->load->model('muser', 'user')->load($this->session->userdata('UID'));
        $this->load->vars($data);
        $this->load->view('view');

    }


    public function send($notificationId)
    {

		$config = Array(
			'protocol' => $this->config->item('mail_protocol'),
			'smtp_host' => $this->config->item('mail_smtp_host'),
			'smtp_port' => $this->config->item('mail_smtp_port'),
			'smtp_user' => $this->config->item('mail_smtp_user'),
			'smtp_pass' => $this->config->item('mail_smtp_pass'),
			'smtp_timeout' => 30,
			'validation' => TRUE,
			'charset'    => 'utf-8',
			'newline'    => "\r\n"
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->set_mailtype("html");
		$this->email->message($this->compose($notificationId));
		$this->email->from($this->config->item('mail_smtp_user'), 'HHIMS@'.$this->config->item("mail_smtp_sender"));
		 $this->email->to($this->notification->TOID);
		//$this->email->from($this->config->item('mail_smtp_user'));
		$subject
            = $this->notification->getValue("Disease") . " in " . $this->patient->getValue("Address_Village");
		$this->email->subject($subject);
		
		try {
			if (!$this->email->send()){
				 echo $this->email->print_debugger();
			}	
			else{
				$this->load->view('success');
			}
		}	
		catch (Exception $e) {
		}		
		
		
		
		
    }

    public function compose($notificationId)
    {
        $data = array();
        $notification = $this->load->model('mnotification');
        $notification->load($notificationId);
        $this->notification = $notification;
        $data['notification'] = $notification;
        if ($notification->getValue("Episode_Type") == 'admission') {
            $admid = $notification->getValue("EPISODEID");
            $admission = $this->load->model('madmission', 'admission');
            $admission->openId($admid);
            $data['admission'] = $admission;
            $patient = $this->load->model('mpatient', 'patient')->load($admission->PID);
            $this->patient = $patient;
            $ward = $this->load->model('mward', 'ward')->OpenId($admission->getValue("Ward"));
            $data['ward'] = $ward;
            $doctor = $this->load->model('muser', 'doctor');
            $doctor->openId($notification->getValue("ConfirmedBy"));
            $data['epicode_type'] = "Admission";
            $data['subject']
                = $notification->getValue("Disease") . " in " . $patient->getValue("Address_Village")
                . " (NOTIFICATION)";
        } else {
            if ($notification->getValue("Episode_Type") == 'opd') {
                $opdid = $notification->getValue("EPISODEID");
                $opd = $this->load->model('mopd', 'opd');
                $opd->openId($opdid);
                $data['opd'] = $opd;
                $data['epicode_type'] = "Opd";
                $patient = $this->load->model('mpatient', 'patient')->load($opd->PID);
                $this->patient = $patient;
                $doctor = $this->load->model('muser', 'doctor');
                $doctor->openId($notification->getValue("ConfirmedBy"));

            } else {
                echo " Episode not found";
            }
        }
        $data['doctor'] = $doctor;
        $data['subject']
            = $notification->getValue("Disease") . " in " . $patient->getValue("Address_Village")
            . " (NOTIFICATION)";
        $hospital = $this->load->model('mhospital', 'hospital')->load($patient->HID);
        $data['hospital'] = $hospital;
        $this->hospital=$hospital;
        $data['patient'] = $patient;
        if ($notification->getValue("LabConfirm") == 1) {
            $pat_lab_d = "Yes";
        } else {
            $pat_lab_d = "No";
        } 
		if ($notification->getValue("Confirmed") == 1) {
            $Confirmed = "Yes";
        } else {
            $Confirmed = "No";
        }
        $data['lab'] = $pat_lab_d;
        $data['Confirmed'] = $Confirmed;
        $data['pat_lab_d'] = $pat_lab_d;
        $data['user'] = $this->load->model('muser', 'user')->load($this->session->userdata('UID'));
        $this->load->vars($data);
        return $this->load->view('email', '', true);
    }

}


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */