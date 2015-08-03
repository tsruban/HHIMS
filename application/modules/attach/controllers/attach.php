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

session_start();
class Attach extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model("mpersistent");
    }

	public function index()
	{	
		return;
	}
	public function portrait($pid){
		if (isset($pid)&& ($pid>0)){
			$data["PID"] = $pid;
			$this->load->vars($data);
			$this->load->view('attach_portrait');	
		}
	}
		
	public function save_portrait(){
		$valid_exts = array('jpeg', 'jpg', 'png', 'gif');
		$max_file_size = 200 * 1024; #200kb
		$nw = $nh = 200; # image with # height
		$this->load->model('mpersistent');
		$this->load->helper('form');
		$this->load->helper('directory');
		$data["patient"] = $this->mpersistent->open_id($this->input->post("PID"),"patient","PID");
		//print_r($data["patient"]);
		//print_r(directory_map('./attach/'.$data["patient"]["HIN"]));
		//print_r($data["patient"]);
		if(!is_dir('./attach/'.$data["patient"]["HIN"])){
			mkdir('./attach/'.$data["patient"]["HIN"],0755,TRUE);
		} 
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ( isset($_FILES['image']) ) {
				if (! $_FILES['image']['error'] && $_FILES['image']['size'] < $max_file_size) {
					$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
					if (in_array($ext, $valid_exts)) {
							$path = './attach/'.$data["patient"]["HIN"]. '/'.$data["patient"]["HIN"].'_portrait.jpg';// . $ext;
							$size = getimagesize($_FILES['image']['tmp_name']);

							$x = (int) $this->input->post("x");
							$y = (int) $this->input->post("y");
							$w = (int) $_POST['w'] ? $this->input->post("w") : $size[0];
							$h = (int) $_POST['h'] ? $this->input->post("h") : $size[1];
							$data = file_get_contents($_FILES['image']['tmp_name']);
							$vImg = imagecreatefromstring($data);
							$dstImg = imagecreatetruecolor($nw, $nh);
							imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
							imagejpeg($dstImg, $path);
							imagedestroy($dstImg);
							header("Status: 200");
							header("Location: ".site_url('/patient/view/'.$this->input->post("PID")));
							
						} else {
							echo 'unknown problem!';
						} 
				} else {
					echo 'file is too small or large';
				}
			} else {
				echo 'file not set';
			}
		} else {
			echo 'bad request!';
		}

	}
	
	public function view($hash){
		$this->load->model('mpersistent');
		$data["attach"] = $this->mpersistent->open_id($hash,"attachment","Attach_Hash");
		$data["patient"] = $this->mpersistent->open_id($data["attach"]["PID"],"patient","PID");
		if (isset($data["patient"]["DateOfBirth"])) {
            $data["patient"]["Age"] = Modules::run('patient/get_age',$data["patient"]["DateOfBirth"]);
        }
		$this->load->vars($data);
        $this->load->view('attach_view');	
	}
	
	public function save(){
		//print_r($_POST);
		//print_r($_FILES);
		if (!$_POST){
			echo "Wrong Data Try again";
			exit;
		}
		if (isset($_POST["PID"])){
			$this->load->model('mpersistent');
			$data["patient_info"] = $this->mpersistent->open_id($_POST["PID"], "patient", "PID");
		}
		else{
			echo "Patient not found. try again";
			exit;
		}
		$config = $this->config->item('upload');
		$config["upload_path"] .=  $data["patient_info"]["HIN"].'/';
		if(!is_dir($config["upload_path"])){
			mkdir($config["upload_path"],0755,TRUE);
		} 
		$this->load->library('upload',$config);
		$this->load->helper('form');
        $this->load->library('form_validation');
		$this->load->model("mpersistent");
		$this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("Attach_Type", "Attach_Type", "required");
       $this->form_validation->set_rules("Attach_To", "Attach_To", "required");
		if ( ! $this->upload->do_upload("Attach_Name"))
		{
			$error = array('error' => $this->upload->display_errors());
			header("Status: 200");
			header("Location: ".site_url('/form/create/attachment/'.$this->input->post("PID")));		
		}
		else
		{
			if ($this->form_validation->run() == FALSE) {
				$error = array('Attach_Type' => "Please select Attach_Type");
				header("Status: 200");
				header("Location: ".site_url('/form/create/attachment/'.$this->input->post("PID")));
			}
			else{
				$data = array('upload_data' => $this->upload->data());
				$save_data = array(
					"Attach_Name" => $data["upload_data"]["orig_name"],
					"Attach_Hash" => md5($data["upload_data"]["raw_name"]),
					"Attach_Link" => $config["upload_path"].$data["upload_data"]["file_name"],
					"PID" =>$this->input->post("PID"),
					"Attach_Type" =>$this->input->post("Attach_Type"),
					"Attach_To" =>$this->input->post("Attach_To"),
					"Attach_Description" =>$this->input->post("Attach_Description")
				);
				$status = $this->mpersistent->create("attachment",$save_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'File Attached'
                );
				if ( $status>0){
					header("Status: 200");
					header("Location: ".site_url('patient/view/'.$this->input->post("PID")));
					return;
				}
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */