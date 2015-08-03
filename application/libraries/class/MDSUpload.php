<?php
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

class MDSUpload 
{
	private static $instance; 
	public $folder = "";
	private $path = "\\";
	public $file_name = "";
	public $upload_type = "";
	public $upload_to = "";
	public $upload_by = "";
	public $patient = "";
	public $link = "";
	public $EPISODEID = "";
	public $hash = "";
	
	private $allowed_types=array("txt","doc","xls","rtf","ppt","pdf","jpg","jpeg","gif","png","xml");
	
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function __construct() {
		if ($this->getOS() == 'win'){
			$this->path = "\\";
		}
		else{
			$this->path = "/";
		}
	}
	
	private function GetBasePath() { 
		return  substr(getcwd(), 0, strlen(getcwd())-strlen("include")-1);
		//substr(getcwd(), 0, strlen(getcwd())-strlen("include")-1);
	}
	
	public function getDefaultFolder(){
		return strtolower(str_replace(" ","_",$_SESSION["LIC_HOS"]));
	}
	
	public function isFileTypeAllowed($file_name){
		if (!in_array(end(explode(".",strtolower($file_name))),$this->allowed_types)) { 
		   return false;
		} 
		return true;  
	}
	public function createFolder(){
		if ($this->patient->getId() >0) {
			$patientFolder ="";
			$patientFolder = $this->getDefaultFolder();
			$this->folder = $this->GetBasePath().$this->path."attach".$this->path.$this->getDefaultFolder();
			if (!file_exists($this->folder)){
				mkdir($this->folder , 0755);
			}			
			$patientFolder = "patient";
			$this->folder = $this->GetBasePath().$this->path."attach".$this->path.$this->getDefaultFolder().$this->path.$patientFolder;
			if (!file_exists($this->folder)){
				mkdir($this->folder , 0755);
			}
			$patientFolder = "patient".$this->path.trim(strtolower(substr($this->patient->getValue("Full_Name_Registered"),0,5)))."_".$this->patient->getId();
			$this->folder = $this->GetBasePath().$this->path."attach".$this->path.$this->getDefaultFolder().$this->path.$patientFolder;
			if (!file_exists($this->folder)){
				mkdir($this->folder , 0755);
			}
			if ($this->upload_to !="patient"){
				$patientFolder = "patient".$this->path.trim(strtolower(substr($this->patient->getValue("Full_Name_Registered"),0,5)))."_".$this->patient->getId().$this->path.$this->upload_to;
				$this->folder = $this->GetBasePath().$this->path."attach".$this->path.$this->getDefaultFolder().$this->path.$patientFolder;
				if (!file_exists($this->folder)){
					mkdir($this->folder , 0755);
				}
			}
		}
		else{
			return -1;
		}
		$this->folder = $this->GetBasePath().$this->path."attach".$this->path.$this->getDefaultFolder().$this->path.$patientFolder;
		if (!file_exists($this->folder)){
			mkdir($this->folder , 0755);
		}
	}	
	private function getOS(){
		$os_string = php_uname('s');
		if (strpos(strtoupper($os_string), 'WIN')!==false)
		{
		return 'win';
		}
		else
		{
		return 'linux';
		}
	}
	private function getLinkURL(){
		return "";
	}
	public function getFileName($file_name){
		$this->hash = md5(uniqid().$this->patient->getId());
		$path_link = md5(uniqid().$this->patient->getId().$file_name).".".end(explode(".",strtolower($file_name)));
		$this->link = trim(strtolower(substr($this->patient->getValue("Full_Name_Registered"),0,5)))."_".$this->patient->getId()."/".$path_link;
		//.".".end(explode(".",strtolower($file_name)))
		return $this->folder.$this->path.$path_link;
	}
}

?>