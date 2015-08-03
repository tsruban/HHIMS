<?php

class MDSLicense 
{
	public $hospital = null;
	public $key= null;
	private $status=false; 
	private static $instance; 
	public $modules = array();
	public static function getInstance() { 
		if(!self::$instance) { 
			self::$instance = new self(); 
		} 
		return self::$instance; 
	} 	
	
	public function makeKey($hospital){
		$key = "";
		$str = md5("MDS".$hospital."FOSS");
		$key = sha1($str);
		return $key;            
	}
	public function moduleKey($h,$m,$f){
		$key = "";
		$str = md5("MDS".$h.$m.$f."FOSS");
		$key = sha1($str);
		return $key;      
	}
	public function checkModuleKey($hospital, $key,$m){
		if ($this->moduleKey($hospital,$m,'on') == $key){
			return true;
		}
		else {
			return false;
		}
	}
	
	public function checkKey($hospital, $key){
		if ($this->makeKey($hospital) == $key ) {
			$this->status = true;
			return $hospital;  
		}
		else{
			$this->status = false;
			return "Information not available or currupted";
		} 
	}

	public function readKey($keyfile){
		$file = $keyfile;
		if (file_exists($file)) {
			$xml = simplexml_load_file($file);
			$lic = null;
			$lic =  $xml->getName($file) ;
			if ($lic != "license") { 
				$this->status = false;
				$this->hospital = "License not available"; 
			}
			foreach($xml as $key0 => $value){
				if ($key0 == "hospital"){
					$this->hospital = trim((string)$value);
				}
				elseif($key0 == "key"){
					$this->key = trim((string)$value);
				}
				else{
					$this->$key0 = trim((string)$value);
					$ukey = strtoupper($key0 );
					$tmp_val = array("key"=>$ukey,"val"=>$value);
					array_push($this->modules,$tmp_val);
					$_SESSION[$ukey] = $this->checkModuleKey($this->hospital,$this->$key0,$key0);
				}	
			}
			$_SESSION["LIC_HOS"] = $this->hospital;
			$this->hospital = $this->checkKey($this->hospital, $this->key);
		}
		else {
			$this->status = false;
			$this->hospital = "License not available";
		}
		$_SESSION["LIC"] = md5($this->status); 
		return ;
	}
	
}

function YesNo($b){
    if ($b==1) return "Yes";
    else return  "No";
}

function getAppointmentLink($pid){
	$mdsLic = MDSLicense::GetInstance();
	$mdsLic->readKey('mdsfoss.key');
	if ($mdsLic->checkModuleKey($mdsLic->hospital,$_SESSION[strtoupper("appointmentsystem")],'appointmentsystem')){
		return "<input type='button' class='submenuBtn'  value='".getPrompt("Give an Appointment")."' onclick=self.document.location='home.php?page=appointment&action=New&PID=".$pid."'>\n";
	}
	//style='background:url(images/attachment.png) no-repeat;background-position:right;' 
}
function getAttachLink($type,$pid,$epsid){
	$mdsLic = MDSLicense::GetInstance();
	$mdsLic->readKey('mdsfoss.key');
	if ($mdsLic->checkModuleKey($mdsLic->hospital,$_SESSION[strtoupper("attachfile")],'attachfile')){
		return "<input type='button' class='submenuBtn' value='".getPrompt("Attach file")."' onclick=self.document.location='home.php?page=attach&TYPE=".$type."&PID=".$pid."&EPISODE=".$epsid."'>\n";
	}
}
function getLICInfo(){
	$mdsLic = MDSLicense::GetInstance();
	$mdsLic->readKey('mdsfoss.key');
	$out = "";
	$out .= "HOSPITAL NAME=".$mdsLic->hospital."\n";
	$out .= "HOSPITAL Key=".$mdsLic->key."\n";
	for ($i=0; $i < count($mdsLic->modules); ++$i){
		$out .=$mdsLic->modules[$i]["key"]."=".YesNo($mdsLic->checkModuleKey($mdsLic->hospital,$mdsLic->modules[$i]["val"],strtolower($mdsLic->modules[$i]["key"])))."\n";
	}
    return $out;
}
function checkAP(){
    return $_SESSION["AP"];
}
function checkBC(){
    return $_SESSION["BC"];
}
function checkAA(){
    return $_SESSION["AA"];
}
?>
