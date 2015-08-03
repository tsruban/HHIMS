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
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/
class Lookup extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
	 }

	public function index()
	{	
		return;
	}
	public function get_drugs_groups(){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_drugs_groups();
		$json = json_encode($data["list"]);
		echo $json ;
	}	
	public function cannedtext($text){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_canned_text($text);
		if (isset($data["list"]["Text"])){
			echo $data["list"]["Text"];
		}
		else{
			echo '';
		}

	}
	public function get_drugs_sub_groups($gp){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_drugs_sub_groups($gp);
		$json = json_encode($data["list"]);
		echo $json ;
	}	
	public function get_drug_name($sgp=null){
		$sgp = $_POST["id"];
		$drug_stock_id = $_POST["drug_stock_id"];
		if ($sgp=="")$sgp=null;
		if ($drug_stock_id=="")$drug_stock_id=null;
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_drug_name($sgp,$drug_stock_id);
		$json = json_encode($data["list"]);
		echo $json ;
	}	
	public function get_formulation($nme){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_formulation($nme);
		$json = json_encode($data["list"]);
		echo $json ;
	}	
	public function get_frequency(){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_frequency();
		$json = json_encode($data["list"]);
		echo $json ;
	}
	
	public function get_dosage(){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_dosage();
		$json = json_encode($data["list"]);
		echo $json ;
	}
	
	public function get_period(){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_period();
		$json = json_encode($data["list"]);
		echo $json ;
	}
	
	public function snomed(){
        $type=$_GET["type"];
        echo $this->loadMDSPager($type);
	}	
															
	public function icd(){
        $type=$_GET["type"];
       
        if($this->config->item('purpose') != "PP"){
        	echo $this->loadICD($type);
       }else{
       	//PP Configuration 
       	//this load only the ICD code linked with a given complaint
        	$complaint = $_GET["complaint"];
       		echo $this-> loadICDforICPC($type,$complaint);
        }     
	}
	
	public function complaint($key=null){
		$key =$_GET["term"];
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_complaint_list($key);
		$json = json_encode($data["list"]);
		echo $json ;
	}

	function get_ICD_code($code){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_ICD_code($code);

		if (!$data["list"]) return null;
		echo  $data["list"];
	}
	function get_ICD_info($icd_code){
		$this->load->model('mlookup');
		$data["list"] = $this->mlookup->get_ICD_info($icd_code);
		
		if (!$data["list"]) return null;
		echo  json_encode($data["list"]);
	}
    public function village($key=null){
        $key =$_GET["term"];
        $this->load->model('mlookup');
        $data["list"] = $this->mlookup->get_village_list($key);
        $json = json_encode($data["list"]);
        echo $json ;
    }

    //disorder
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
        $this->mpager->setDivId('snomed_search');
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

        $conceptName='';
        $termName='';
        foreach($this->mpager->getColModelJSAR() as $key=>$value){
            if($key=='"CONCEPTID"'){
                $conceptName=$value->getName();
            }
            if($key=='"TERM"'){
                $termName=$value->getName();
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
                var rowData = {$this->mpager->getGrid()}.jqGrid('getRowData',rowId);
                var st= rowData['snomed_text'];
                var sc= rowData['snomed_code'];
                $('#SNOMED_Text').val(rowData['$termName']);
                $('#SNOMED_Code').val(rowData['$conceptName']);
				form_update();
                $('#snomedDiv').modal('toggle');
            });
            }";

        //report starts
        if(isset($frm["ORIENT"])){
            $this->mpager->setOrientation_EL($frm["ORIENT"]);
        }
        if(isset($frm["TITLE"])){
            $this->mpager->setTitle_EL($frm["TITLE"]);
        }
        $this->mpager->setWidth('540');
        $this->mpager->setColHeaders_EL(isset($frm["COL_HEADERS"])?$frm["COL_HEADERS"]:$frm["DISPLAY_LIST"]);
        //report endss

        return $this->mpager->render(false);
    }
 private function loadICD($fName="icd10") {
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
        $this->mpager->setDivId('icd_search');
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
                var rowData = {$this->mpager->getGrid()}.jqGrid('getRowData',rowId);
                var st= rowData['snomed_text'];
                var sc= rowData['snomed_code'];
                $('#ICD_Text').val(rowData['icd_text']);
                $('#ICD_Code').val(rowData['icd_code']); 
                $('#icdDiv').modal('toggle');    
            });
            }";

        //report starts
        if(isset($frm["ORIENT"])){
            $this->mpager->setOrientation_EL($frm["ORIENT"]);
        }
        if(isset($frm["TITLE"])){
            $this->mpager->setTitle_EL($frm["TITLE"]);
        }
        $this->mpager->setWidth('540');
        $this->mpager->setColHeaders_EL(isset($frm["COL_HEADERS"])?$frm["COL_HEADERS"]:$frm["DISPLAY_LIST"]);
        //report endss

        return $this->mpager->render(false);
    }	
    
    
    // PP configuration
    // load only the ICD code linked with a given complaint
     private function loadICDforICPC($fName="icd10",$complaint) {
          	
       $path='application/forms/' . $fName . '.php';
        require $path;
        $complaint = $complaint;
        $frm = $form;
        $columns = array('Code', 'Name');
       // $columns = $frm["LIST"];
        $table = $frm["TABLE"];
        $sql = "SELECT ";

        foreach ($columns as $column) {
            $sql.=$table.".".$column . ',';
        }
        $sql = substr($sql, 0, -1);
        $sql.=" FROM $table ";
        $sql.=" , complaints, icd_icpc ";
        $sql.=" WHERE $table.icdid = icd_icpc.icdid ";
        $sql.=" AND icd_icpc.compid = complaints.compid ";
        $sql.="AND complaints.compid ";
        $sql.="IN (";
        $sql.="SELECT compid ";
        $sql.="FROM complaints ";
        $sql.="WHERE name LIKE '$complaint') ";
        
        $this->load->model('mpager');
        $this->mpager->setSql($sql);
        $this->mpager->setDivId('icd_search');
        $this->mpager->setSortorder('asc');
        //set colun headings
        $colNames = array('Code', 'Name');
    	 
     
        $this->mpager->setColNames($colNames);

        //set captions
        $this->mpager->setCaption($frm["CAPTION"]);
        //set row id
        $this->mpager->setRowid($frm["ROW_ID"]);

        //set column models
       	$colModel= array('Code' => array('width' => "20px"), 'Name');
     	foreach ($colModel as $columnName => $model) {
            if (gettype($model) == "array") {
                $this->mpager->setColOption($columnName, $model);
            }
        }
      
// PP configuration
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
                var rowData = {$this->mpager->getGrid()}.jqGrid('getRowData',rowId);
                var st= rowData['snomed_text'];
                var sc= rowData['snomed_code'];
                $('#ICD_Text').val(rowData['icd_text']);
                $('#ICD_Code').val(rowData['icd_code']); 
                $('#icdDiv').modal('toggle');    
            });
            }";
        //report starts
        if(isset($frm["ORIENT"])){
            $this->mpager->setOrientation_EL($frm["ORIENT"]);
        }
        if(isset($frm["TITLE"])){
            $this->mpager->setTitle_EL($frm["TITLE"]);
        }
        $this->mpager->setWidth('540');
        $this->mpager->setColHeaders_EL(isset($frm["COL_HEADERS"])?$frm["COL_HEADERS"]:$frm["DISPLAY_LIST"]);
        //report endss

        return $this->mpager->render(false);
    }	
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */