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


class Preference extends MX_Controller {

	public $data = array();
	
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load_default_paging_config();
        $this->load->helper('url');
         $this->load->library('session');
		//$this->load->library('MdsCore');
	 }

	public function index($pre_page=NULL)
	{
		if(isset($_GET["mid"])){
			$this->session->set_userdata('mid', $_GET["mid"]);
		}
		$this->load('user');
	}
	public function load($pre_page=NULL) {
//		$data["pre_page"] = $pre_page;
//		$this->load->vars($data);
//		$this->load->view('preference');
        $this->loadMDSPager($pre_page);
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
        
 //PP configuration
 //Here is to change the column name
       if ($this->session->UserData("Config") == 'config_admin'){
       	
       			if($table != "complaints"){	
        			 array_push($frm["DISPLAY_LIST"], "Edit");
       			}
        		$erasable_menu = array('visit_type','treatment','injection', 'who_drug','village', 'drugs_dosage',
        		'drugs_frequency','drugs_period');
        		if(in_array($table, $erasable_menu)){	
        	 	 array_push($frm["DISPLAY_LIST"], "Delete");
        		 }     	   		 
        }
        
        foreach ($frm["DISPLAY_LIST"] as $colName) {
            array_push($colNames, $colName);
        }
        
        
        $this->mpager->setColNames($colNames);

        //set captions
        $this->mpager->setCaption($frm["CAPTION"]);
        //set row id
        $this->mpager->setRowid($frm["ROW_ID"]);
        
       $testdata=array();

        //set column models
        foreach ($frm["COLUMN_MODEL"] as $columnName => $model) { 
        	if (gettype($model) == "array") { 
		   		$this->mpager->setColOption($columnName, $model);
            }
        }
                
        //set actions
        $action = $frm["ACTION"];
        //PP configuration
         if ($this->session->UserData("Config") == 'config_admin'){
         	//Doesn't allow this edit function by clicking on the row
        $this->mpager->gridComplete_JS = "function() {
            var c = null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow','cursor':'pointer'});
            }).mouseout(function(e){
                $(this).css('background',c);   
            });
            }";
         }else{
        // Allow the edit function as it used to be
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
         }


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
		$this->load->view('preference');
//        return "<h1>$sql";
    }


	public function user(){
		 
		$this->load->model('msystem');
		$this->data["TABLE"] = "user";
		$this->data["table_header"] = "User list";
		$this->data["header"] =array( 'UID', 'FirstName', 'OtherName', 'DateOfBirth', 'Gender','Post','UserName','UserGroup','Address_Village','Active');
		$this->data["display_header"] = array( 'Id', 'First name', 'Other name', 'Date of birth', 'Gender','Post','User name','User group','Village','Active');
		$this->data["table"] = "user";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/user';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("user");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}		
	public function user_group(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "user_group";
		$this->data["table_header"] = "User groups";
		$this->data["header"] =array( 'UGID', 'Name','MainMenu','Active');
		$this->data["display_header"] = array( 'ID', 'Name','Home page','Active');
		$this->data["table"] = "user_group";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/user_group';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("user_group");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function permission(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "permission";
		$this->data["table_header"] = "Permission allocations";
		$this->data["header"] =array( 'PRMID','UserGroup', 'Remarks');
		$this->data["display_header"] = array( 'ID','UserGroup', 'Remarks');
		$this->data["table"] = "permission";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/permission';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("permission");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}		
	public function visit_type(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "visit_type";
		$this->data["table_header"] = "OPD visit types";
		$this->data["header"] =array( 'VTYPID', 'Name', 'Remarks','Stock','Active');
		$this->data["display_header"] = array( 'ID', 'Name', 'Remarks','Pharmacy stock','Active');
		$this->data["table"] = "visit_type";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/visit_type';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("visit_type");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function hospital(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "hospital";
		$this->data["table_header"] = "Hospital settings";
		$this->data["header"] =array( 'HID', 'Name','Code', 'Type','Address_Village','Active');
		$this->data["display_header"] = array( 'HID', 'Name','Code', 'Type','Village','Active');
		$this->data["table"] = "hospital";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/hospital';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("hospital");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function user_menu(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "user_menu";
		$this->data["table_header"] = "User menus";
		$this->data["header"] =array( 'UMID', 'Name', 'UserGroup','Link','MenuOrder','Active');
		$this->data["display_header"] = array( 'ID', 'Name', 'UserGroup','Link','MenuOrder','Active');
		$this->data["table"] = "user_menu";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/user_menu';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("user_menu");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}		
	public function institution(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "institution";
		$this->data["table_header"] = "Institution list";
		$this->data["header"] =array( 'INSTID', 'Name', 'Type','Email1','Telephone1','Address_Village','Active');
		$this->data["display_header"] = array( 'Id', 'Name', 'Type','E mail',' Telephone','Village','Active');
		$this->data["table"] = "institution";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/institution';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("institution");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}		
	
	public function complaints(){
		 
		$this->load->model('msystem');
		$this->data["TABLE"] = "complaints";
		$this->data["table_header"] = "Complaints list";
		$this->data["header"] = array( 'COMPID', 'Name', 'Type','isNotify','ICDLink','Remarks');
		$this->data["display_header"] = array( 'ID', 'Name', 'Type','isNotify','ICDLink','Remarks');
		$this->data["table"] = "complaints";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/complaints';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("complaints");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}
	public function treatment(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "treatment";
		$this->data["table_header"] = "Treatment list";
		$this->data["header"] = array( 'TREATMENTID','Treatment', 'Type','Remarks','Active');
		$this->data["display_header"] = array( 'ID','Treatment', 'Type','Remarks','Active');
		$this->data["table"] = "treatment";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/treatment';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("treatment");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}
	public function Drugs(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "Drugs";
		$this->data["table_header"] = "Drugs list";
		$this->data["header"] = array( 'DRGID', 'Name', 'Type','dDosage','dFrequency','Stock','ClinicStock','Active');
		$this->data["display_header"] = array( 'ID', 'Name', 'Type','Dosage','Frequency','Stock','Clinic Stock','Active');
		$this->data["table"] = "Drugs";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/Drugs';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("Drugs");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function drugs_dosage(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "drugs_dosage";
		$this->data["table_header"] = "Drugs dosage";
		$this->data["header"] = array( 'DDSGID', 'Dosage','Type', 'Factor','Active');
		$this->data["display_header"] = array( 'ID', 'Dosage', 'Type','Factor','Active');
		$this->data["table"] = "drugs_dosage";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/drugs_dosage';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("drugs_dosage");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function drugs_frequency(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "drugs_frequency";
		$this->data["table_header"] = "Drugs frequency";
		$this->data["header"] = array( 'DFQYID', 'Frequency', 'Factor','Active');
		$this->data["display_header"] = array( 'ID', 'Frequency','Factor','Active');
		$this->data["table"] = "drugs_frequency";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/drugs_frequency';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("drugs_frequency");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function canned_text(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "canned_text";
		$this->data["table_header"] = "Canned text list";
		$this->data["header"] = array( 'CTEXTID','Code', 'Text','Remarks','Active');
		$this->data["display_header"] = array( 'ID','Code', 'Text','Remarks','Active');	
		$this->data["table"] = "canned_text";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/canned_text';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("canned_text");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function lab_tests(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "lab_tests";
		$this->data["table_header"] = "Lab tests";
		$this->data["header"] =array( 'LABID', 'Department', 'GroupName','Name', 'RefValue');
		$this->data["display_header"] = array( 'ID', 'Department', 'Group Name','Test Name', 'Ref. Value');
		$this->data["table"] = "lab_tests";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/lab_tests';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("lab_tests");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function lab_test_group(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "lab_test_group";
		$this->data["table_header"] = "Lab tests groups";
		$this->data["header"] =array( 'LABGRPTID', 'Name','Active');
		$this->data["display_header"] = array( 'ID', 'Name','Active');
		$this->data["table"] = "lab_test_group";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/lab_test_group';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("lab_test_group");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}		
	public function lab_test_department(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "lab_test_department";
		$this->data["table_header"] = "Lab tests departments";
		$this->data["header"] =array( 'LABDEPTID', 'Name','Active');
		$this->data["display_header"] = array( 'ID', 'Name','Active');
		$this->data["table"] = "lab_test_department";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/lab_test_department';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("lab_test_department");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}		

	public function ward(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "ward";
		$this->data["table_header"] = "Wards list";
		$this->data["header"] =array( 'WID','Name', 'Type','Telephone','BedCount','Remarks','Active');
		$this->data["display_header"] = array( 'ID','Name', 'Type','Telephone','BedCount','Remarks','Active');
		$this->data["table"] = "ward";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/ward';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("ward");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function finding(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "finding";
		$this->data["table_header"] = "SNOMED findings";
		$this->data["header"] =array( 'FINDID','CONCEPTID', 'TERM');
		$this->data["display_header"] = array( 'ID','CONCEPTID', 'TERM');
		$this->data["table"] = "finding";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/finding';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("finding");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	
	public function disorder(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "disorder";
		$this->data["table_header"] = "SNOMED disorders";
		$this->data["header"] =array( 'DISORDERID','CONCEPTID', 'TERM');
		$this->data["display_header"] = array( 'ID','CONCEPTID', 'TERM');
		$this->data["table"] = "disorder";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/disorder';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("disorder");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function event(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "event";
		$this->data["table_header"] = "SNOMED events";
		$this->data["header"] =array( 'EVENTID','CONCEPTID', 'TERM');
		$this->data["display_header"] = array( 'ID','CONCEPTID', 'TERM');
		$this->data["table"] = "event";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/event';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("event");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}		
	public function procedures(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "procedures";
		$this->data["table_header"] = "SNOMED procedures";
		$this->data["header"] =array( 'PROCEDUREID','CONCEPTID', 'TERM');
		$this->data["display_header"] = array( 'ID','CONCEPTID', 'TERM');
		$this->data["table"] = "procedures";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/procedures';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("procedures");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function icd10(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "icd10";
		$this->data["table_header"] = "ICD10 list";
		$this->data["header"] =array( 'ICDID','Code', 'Name','isNotify','Remarks');
		$this->data["display_header"] = array( 'ICDID','Code', 'Name','isNotify','Remarks');
		$this->data["table"] = "icd10";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/icd10';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("icd10");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}	
	public function immr(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "immr";
		$this->data["table_header"] = "IMMR list";
		$this->data["header"] =array( 'IMMRID','Code', 'Name','Category','ICDCODE');
		$this->data["display_header"] = array( 'IMMRID','IMMR Code', 'IMMR Name','Category','ICDCODE');
		$this->data["table"] = "immr";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/immr';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("immr");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}		
	public function village(){
		 	
		$this->load->model('msystem');
		$this->data["TABLE"] = "village";
		$this->data["table_header"] = "Village list";
		$this->data["header"] =array( 'VGEID', 'District','DSDivision', 'GNDivision','Code','Active');
		$this->data["display_header"] = array( 'ID', 'District','DSDivision', 'GNDivision','Code','Active');
		$this->data["table"] = "village";
		$this->data["config"]['base_url'] = base_url().'index.php/preference/load/village';
		$this->data["config"]['total_rows'] = $this->msystem->get_total_active("village");
		$this->load->vars($this->data);
		$this->load->view('preference_list');
	}			
	
	public function load_default_paging_config(){
		$this->data["config"]['uri_segment'] = 4;
		$this->data["config"]['per_page'] = 20; 
		$this->data["config"]['first_link'] = 'First';
		$this->data["config"]['first_tag_open'] = '<span  class="first">';
		$this->data["config"]['first_tag_close'] = '</span>';
		$this->data["config"]['last_link'] = 'Last';
		$this->data["config"]['last_tag_open'] = '<span  class="last">';
		$this->data["config"]['last_tag_close'] = '</span>';
		$this->data["config"]['full_tag_open'] = '<p class="page-cont">';
		$this->data["config"]['full_tag_close'] = '</p>';
		$this->data["config"]['num_tag_open'] = '<span class="digit">';
		$this->data["config"]['num_tag_close'] = '</span>';
		$this->data["config"]['next_link'] = '&#187;';
		$this->data["config"]['next_tag_open'] = '<span class="next">';
		$this->data["config"]['next_tag_close'] = '</span>';
		$this->data["config"]['prev_link'] = '&#171;';
		$this->data["config"]['prev_tag_open'] = '<span class="prev">';
		$this->data["config"]['prev_tag_close'] = '</span>';				
		$this->data["config"]['cur_tag_open'] = '<span class="cur">';
		$this->data["config"]['cur_tag_close'] = '</span>';
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */