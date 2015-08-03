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
class Search extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
	 }

	public function index()
	{	
		return;
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
	
	public function sample_order(){
      $qry = "SELECT 
	  lab_order.LAB_ORDER_ID,
	  lab_order.OrderDate,
	  patient.PID as PID, 
	  CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name) as patient_name ,
	  lab_order.TestGroupName,
	  lab_order.Priority,
	  lab_order.Collection_Status
	  
	  from lab_order 
	  LEFT JOIN `patient` ON patient.PID = lab_order.PID 
	  where (lab_order.Active =1)
	  
			";
        $this->load->model('mpager',"page");
		
        $page = $this->page;
        $page->setSql($qry);
        $page->setDivId("patient_list"); //important
        $page->setDivClass('');
        $page->setRowid('LAB_ORDER_ID');
        $page->setCaption("Sample collection list");
        $page->setShowHeaderRow(true);
        $page->setShowFilterRow(true);
        $page->setShowPager(true);
        $page->setColNames(array("","Date", "ID", "Patient","Test","Priority","Status"));
        $page->setRowNum(25);
        $page->setColOption("LAB_ORDER_ID", array("search" => false, "hidden" => true));
        $page->setColOption("PID", array("search" => true, "hidden" => false));
		$page->setColOption("OrderDate", array("search" => true, "hidden" => false ));
        $page->setColOption("patient_name", array("search" => true, "hidden" => false));
        
        $page->setColOption("Collection_Status", array("search" => false, "hidden" => false));
        $page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/form/edit/lab_order_update")."/'+rowId+'?CONTINUE=search/sample_order';
        });
        }";
        $page->setOrientation_EL("L");
		$data['pager'] = $page->render(false);
		$this->load->vars($data);
        $this->load->view('search/sample_order');		
	}
	public function ward(){
      $qry = "SELECT 
	  WID,
	  Name,
	  Telephone,
	  BedCount, 
	  Remarks 	  
	  from ward 
	  where (Active =1)
	  
			";
        $this->load->model('mpager',"page");
		
        $page = $this->page;
        $page->setSql($qry);
        $page->setDivId("ward_list"); //important
        $page->setDivClass('');
        $page->setRowid('WID');
        $page->setCaption("Ward list");
        $page->setShowHeaderRow(true);
        $page->setShowFilterRow(true);
        $page->setShowPager(true);
        $page->setColNames(array("WID","Name", "Telephone", "BedCount","Remarks"));
        $page->setRowNum(25);
        $page->setColOption("WID", array("search" => false, "hidden" => true));
        $page->setColOption("Telephone", array("search" => true, "hidden" => false));
		$page->setColOption("BedCount", array("search" => true, "hidden" => false ));
        $page->setColOption("Remarks", array("search" => true, "hidden" => false));
        $page->gridComplete_JS
            = "function() {
        $('#ward_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/ward/view")."/'+rowId+'?CONTINUE=search/ward';
        });
        }";
        $page->setOrientation_EL("L");
		$data['pager'] = $page->render(false);
		$this->load->vars($data);
        $this->load->view('search/ward_list');		
	}
		
	public function lab_orders($dept=null){
		  $qry = "SELECT 
		  lab_order.LAB_ORDER_ID,
		  lab_order.Dept,
		  lab_order.OrderDate,
		  patient.PID as PID, 
		  CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name) as patient_name ,
		  lab_order.TestGroupName,
		  lab_order.Priority,
		  lab_order.Collection_Status,
		  lab_order.Status
		  
		  from lab_order 
		  LEFT JOIN `patient` ON patient.PID = lab_order.PID 
		  where (lab_order.Active =1)
		
			";
		if ($dept){
			$qry .= ' and (Dept = "'.$dept.'")';
		}
		else{
			$qry .= ' and (Dept = "OPD")';
		}
        $this->load->model('mpager',"page");
		
        $page = $this->page;
        $page->setSql($qry);
        $page->setDivId("patient_list"); //important
        $page->setDivClass('');
        $page->setRowid('LAB_ORDER_ID');
		if ($dept){
			$data["table_title"]="Lab order list";
			$page->setCaption($data["table_title"]);
		}
		else{
			$data["table_title"]="OPD lab order list";
			$page->setCaption($data["table_title"]);
		}
        $page->setShowHeaderRow(true);
        $page->setShowFilterRow(true);
        $page->setShowPager(true);
        $page->setColNames(array("","Dept","Date", "ID", "Patient","Test","Priority","Collection Status","Result Status"));
        $page->setRowNum(25);
        $page->setColOption("Dept", array("search" => false, "hidden" => false,"width"=>"30px"));
        $page->setColOption("LAB_ORDER_ID", array("search" => false, "hidden" => true));
        $page->setColOption("PID", array("search" => true, "hidden" => false,"width"=>"50px"));
		$page->setColOption("OrderDate", array("search" => true, "hidden" => false,"width"=>"100px" ));
        $page->setColOption("patient_name", array("search" => true, "hidden" => false));
        
        $page->setColOption("Collection_Status", array("search" => false, "hidden" => false));
        $page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("laboratory/process_result/")."/'+rowId+'?CONTINUE=search/lab_orders/".$dept."';
        });
        }";
        $page->setOrientation_EL("L");
		$data['pager'] = $page->render(false);
		$this->load->vars($data);
        $this->load->view('search/lab_order');		
	}
	
		
	
	
	public function procedures_order(){
      $qry = "SELECT 
	  opd_treatment.OPDTREATMENTID,
	  opd_treatment.CreateDate,
	  patient.PID as PID, 
	  CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name) as patient_name ,
	  opd_treatment.Treatment,
	  opd_treatment.Status
	  
	  from opd_treatment 
	  LEFT JOIN `opd_visits` ON opd_visits.OPDID = opd_treatment.OPDID 
	  LEFT JOIN `patient` ON patient.PID = opd_visits.PID 
	  where (opd_treatment.Active =1)
	  
			";
        $this->load->model('mpager',"page");
		
        $page = $this->page;
        $page->setSql($qry);
        $page->setDivId("patient_list"); //important
        $page->setDivClass('');
        $page->setRowid('OPDTREATMENTID');
        $page->setCaption("Procedure order list");
        $page->setShowHeaderRow(true);
        $page->setShowFilterRow(true);
        $page->setShowPager(true);
        $page->setColNames(array("","Date", "ID", "Patient","Treatment","Status"));
        $page->setRowNum(25);
        $page->setColOption("OPDTREATMENTID", array("search" => false, "hidden" => true));
        $page->setColOption("PID", array("search" => true, "hidden" => false));
		$page->setColOption("CreateDate", array("search" => true, "hidden" => false ));
        $page->setColOption("patient_name", array("search" => true, "hidden" => false));
        
        $page->setColOption("Status", array("search" => false, "hidden" => false));
        $page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/form/edit/opd_treatment_update")."/'+rowId+'?CONTINUE=search/procedures_order';
        });
        }";
        $page->setOrientation_EL("L");
		$data['pager'] = $page->render(false);
		$this->load->vars($data);
        $this->load->view('search/procedures_order');	
	}	
	
	
	
	public function injection_order(){
      $qry = "SELECT 
	  patient_injection.patient_injection_id,
	  patient_injection.CreateDate,
	  patient.PID as PID, 
	  CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name) as patient_name ,
	  injection.name,
	  injection.dosage,
	  patient_injection.Status
	  from patient_injection 
	  LEFT JOIN `patient` ON patient.PID = patient_injection.PID 
	  LEFT JOIN `injection` ON injection.injection_id = patient_injection.injection_id 
	  
	  where (patient_injection.Active =1)
	  
			";
        $this->load->model('mpager',"page");
		
        $page = $this->page;
        $page->setSql($qry);
        $page->setDivId("patient_list"); //important
        $page->setDivClass('');
        $page->setRowid('patient_injection_id');
        $page->setCaption("Injection order list");
        $page->setShowHeaderRow(true);
        $page->setShowFilterRow(true);
        $page->setShowPager(true);
        $page->setColNames(array("","Date", "ID", "Patient","Injection","Dose","Status"));
        $page->setRowNum(25);
        $page->setColOption("patient_injection_id", array("search" => false, "hidden" => true));
        $page->setColOption("PID", array("search" => true, "hidden" => false));
		$page->setColOption("CreateDate", array("search" => true, "hidden" => false ));
        $page->setColOption("patient_name", array("search" => true, "hidden" => false));
        
        $page->setColOption("Status", array("search" => false, "hidden" => false));
        $page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/form/edit/patient_injection_update")."/'+rowId+'?CONTINUE=search/injection_order';
        });
        }";
        $page->setOrientation_EL("L");
		$data['pager'] = $page->render(false);
		$this->load->vars($data);
        $this->load->view('search/procedures_order');	
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
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */