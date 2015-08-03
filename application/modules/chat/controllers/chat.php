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
class Chat extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
	 }

	public function index($user_id)
	{
		//$this->load_chat($user_id);
	}
	function close($chat_session){
		$this->load->model('mchat');
		if ($this->mchat->chat_close($chat_session,$this->session->userdata('UID'))){
			$this->session->set_userdata('CHAT_SESSION',null);
			$this->session->set_userdata('CHAT_USER', $res_uid);
		}
	}
	function load($chat_session){
		$this->load->model('mchat');
		$this->load->helper('form');
		$data["chat_session"] = $chat_session ;
		//$chat_user_id = $this->session->userdata('CHAT_USER') ;
		$data["chat_user"] = $this->mchat->get_chat_user($chat_session,$this->session->userdata('UID'));
		if (!$data["chat_user"]){
			$data["error"] = "Unknown Session";
			$this->load->vars($data);
			$this->load->view('load_chat');
		}
		else{
			$this->load->vars($data);
			$this->load->view('load_chat');
		}
	}
	public function load_chat($res_uid){
		$data = array();
		$this->load->model('mchat');
		$chat_session = null;
		$chat_session_data = $this->mchat->check_chat_session($res_uid,$this->session->userdata('UID'));
		
		if (isset( $chat_session_data["Session_Id"])){
			$chat_session = $chat_session_data["Session_Id"];
			$this->session->set_userdata('CHAT_SESSION', $chat_session);
			//$this->session->set_userdata('CHAT_USER', $res_uid);
			echo $chat_session;
		}
		else{
			$chat_session =  $this->mchat->create_chat_session($res_uid,$this->session->userdata('UID'));
			$this->session->set_userdata('CHAT_SESSION', $chat_session);
			//$this->session->set_userdata('CHAT_USER', $res_uid);
			echo $chat_session;
		}
	}	
	public function change_status_to($sts){
		$this->load->model('mchat');
		echo $this->mchat->change_status_to($this->session->userdata('UID'),$sts);
		
	}
	public function get_chat_list(){
		$this->load->model('mchat');
		$data["user_list"] = $this->mchat->get_online_user_list($this->session->userdata('UID'));
		$data["message_new"] = $this->mchat->get_new_message($this->session->userdata('UID'));
		$data["my_id"] = $this->session->userdata('UID');
		$this->load->vars($data);
		$this->load->view('chat_list');
	}	
	public function my_conversations(){
		$this->load->model('mchat');
		$data["my_conversations"] = $this->mchat->get_my_conversations($this->session->userdata('UID'));
		$this->load->vars($data);
		$this->load->view('my_conversations');
	
	}
	public function message_seen($msg_id){
		$this->load->model('mchat');
		$this->mchat->message_seen($msg_id);
	}
	public function check_message($user_id){
		$this->load->model('mchat');
		if ($this->session->userdata('CHAT_SESSION')){
			echo "{}";
			return;
		}
		$data["message"] = $this->mchat->check_message($user_id);
		
		if (isset($data["message"] )){
		 echo json_encode($data["message"]);
		 return;
		}
		else{
			echo "{}";
			return;
		}
	}	
	public function get_message($session_id){
		$this->load->model('mchat');
		$data["message"] = $this->mchat->get_message($session_id);
		if (isset($data["message"] )){
		 echo json_encode($data["message"]);
		}
		else{
			echo "{}";
		}
	}
	function send_message(){
		if(isset($_POST)){
			$this->load->model('mchat');
			$message = $this->security->xss_clean(trim($_POST['chat_input']));
			$from_user = $this->security->xss_clean(trim($_POST['from_user']));
			$to_user = $this->security->xss_clean(trim($_POST['to_user']));
			$chat_session = $this->security->xss_clean(trim($_POST['chat_session']));

//			$session_status = $this->mchat->session_status($chat_session);			
//			if ($session_status["Status"]  == "CLOSE"){
				$data = array('Message'=>$message,'FROM_ID'=>$from_user,'TO_ID'=>$to_user,'Session_Id'=>$chat_session,'SentAt'=>date("Y-m-d H:i:s"));
//			}
//			else{
//				$data = array('Message'=>$message,'FROM_ID'=>$from_user,'TO_ID'=>$to_user,'Session_Id'=>$chat_session,'SentAt'=>date("Y-m-d H:i:s"),'Seen'=>1);
//			}
			echo $this->mchat->insert_message($data);			
		}
		else{
		echo false;
		}
	}
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */