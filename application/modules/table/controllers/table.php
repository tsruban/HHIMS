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
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/

----------------------------------------------------------------------------------
*/

class Table extends MX_Controller
{

    function __construct()
    {

        parent::__construct();
        $this->checkLogin();
        $this->load->library('encrypt');
    }

    public function index()
    {
        $this->load->view("table_render");
    }

    public function ajaxBacking()
    {


        $page      = (int)$this->sanitize($_POST['page'], false, true);
        $rp        = $this->sanitize($_POST['rows'], false, true);
        $sortname  = $this->sanitize($_POST['sidx'], false, true);
        $sortorder = $this->sanitize($_POST['sord'], false, true);
        $ddtype    = $this->sanitize($_POST['cell']);
        $rowid     = $this->sanitize($_POST['rowid'], false, true);
        $query     = $this->sanitize($_POST['exec']);
        if(isset($_POST['filters'])){
            $filters   = $this->sanitize($_POST['filters'], false, false);
            $filters      = json_decode(trim($filters));
        }else{
            $filters   = null;
        }


        $searchFields = array();
        if (isset($filters->rules)) {
            foreach ($filters->rules as $rule) {
                $searchFields[$rule->field] = $rule->data;
            }
        }

        $ddtype  = json_decode(trim($ddtype));
        $ddtypes = array();
        if (is_array($ddtype)) {
            foreach ($ddtype as $value) {
                if (isset($value->name)) {
                    $ddtypes[$value->name] = array("value"  => $value->value, "table" => $value->table,
                                                   "column" => $value->column);
                }
            }
        }

        $where = '';
        $split = preg_split("/GROUP BY/i", $query);
        if (is_array($split)) {
            $query   = isset($split[0]) ? $split[0] : '';
            $groupBy = isset($split[1]) ? $split[1] : '';
            if ($groupBy != '') {
                $groupBy = " GROUP BY $groupBy";
            }
        }

        if (stripos($query, 'where') == false) {
            $where .= ' where ';
        } else {
            $where .= ' and ';
        }
            
        foreach ($ddtypes as $key => $value) {

            unset($searchField);
            if (isset($searchFields[$key])) {
                $searchField = $searchFields[$key];
            }
            
            if ($sortname == $key) {
                $sortname = $value['column'];
            }
            if ($value["table"] != '') {
                $key = $value["table"] . '.' . '`' . $value['column'] . '`';
                  //PP Configuration
                 $table = $value["table"];
                
            } else {
                $key = '' . $value['column'] . '';
            }
            if (isset($searchField) && $searchField != '') {
            	
                if ($value["value"] == "DDTYPE") {
                	
                	// PP Configuration
                	if ($key == $table.".`"."Delete`"||$key == $table.".`"."Edit`" ){	
                		//jump this where clause because Delete and Edit are not a DB column
                	}else{
                    $where .= "$key like '%$searchField%' and ";
                	}
                } else {
                    if ($value["value"] == "DSTYPE") {
                        $where .= "$key='$searchField' and ";
                    }
                }
            }
            
        }
       

        if (strcasecmp(trim($where), 'where') == 0) {
            $where = '';
        } else {
            $where = substr($where, 0, -4);
        }

 
        $query .= " $where ";

        $query = trim($query);
      
        
//meta data
        unset($result);
        $result = $this->db->query($query);

        $total = $result->num_rows();
        if (!$sortname) {
            $meta     = mysql_fetch_field($result->result_id, 0);
            $sortname = $meta->name;
        }
        if (!$rowid) {
            $meta  = mysql_fetch_field($result->result_id, 0);
            $rowid = $meta->name;
        }
        if (!$sortorder) {
            $sortorder = 'desc';
        }


        $sort = "ORDER BY `$sortname` $sortorder";
        if (!$page) {
            $page = 1;
        }
        if (!$rp) {
            $rp = 10;
        }
        $start = (($page - 1) * $rp);

        $limit = "LIMIT $start, $rp";
        header("Content-type: text/x-json");
        $i      = 0;
        
        //Fields are filled from the DB
        $fields = array();
        while ($i < mysql_num_fields($result->result_id)) {
            $meta = mysql_fetch_field($result->result_id, $i);
            array_push($fields, $meta->name);
            $i++;
        }
//total calc
        $query .= "$groupBy $sort ";

        $total_pages = 0;
        if ($total > 0) {
            $total_pages = ceil($total / $rp);
        }

        $query .= "$limit ";
        unset($result);
        $result            = $this->db->query($query);
        $response          = new stdClass();
        $response->page    = $page;
        $response->total   = $total_pages;
        $response->records = $total;

        $i = 0;
        while ($row = mysql_fetch_array($result->result_id)) {
            $response->rows[$i]['id'] = isset($row[$rowid]) ? $row[$rowid] : '';

            $cell = array();
            foreach ($fields as $field) {
                array_push($cell, $row[$field]);
            }
            
            //PP Configuration
            // Possible delete or edit in configuration menu
          if ($this->session->UserData("Config") == 'config_admin'){
          	 $row_number = $row[$rowid]; 
          	 // Edit button is available for every table except Complaints
          	 if($table != "complaints"){	
          	 
          	 
              $button='<button id="edit_button" title="Edit this row" class="btn btn-default btn-xs" type="button"
               onClick=\'edit("'.$table.'","'.$row_number.'")\'><span class="glyphicon glyphicon-edit"></span></button>
<html><body><script type="text/javascript"> 
function edit(table,row){ ;
var request = $.ajax({url: "'.base_url().'index.php/table/edit_row/",
"type": "post",
"data":{"table":table ,"row":row},
"success" : function(data){  if(data){window.location = "'.base_url().'index.php/table/edit_row?table="+table+"&row="+row+"";}}
 });} 
</script></body></html>';
            
             
	            $response->rows[$i]['button']= $button;
		        array_push($cell, $response->rows[$i]['button']);
          	 }
            
            
            // Deleting is possible in config mode for the erasable_menu
            	$erasable_menu = array('visit_type','complaints','treatment','injection', 'who_drug', 'drugs_dosage',
            	'drugs_frequency','drugs_period','village'); 	
            	if(in_array($table, $erasable_menu)){	      		
            		
            		$button='<button id="delete_button" title=" Remove this row" class="btn btn-default btn-xs" type="button" 
            		onClick=\'delete_row("'.$table.'","'.$rowid.'","'. $row_number.'")\'><span class="glyphicon 
            		glyphicon-remove-circle"></span></button>
<html><body><script type="text/javascript">
function delete_row(table,rowid,row){ ;
var ok = confirm("Are you sure you want to delete this row?");
if (ok) {
    var request = $.ajax({url: "'.base_url().'index.php/table/delete_row/",
	"type": "post",
	"data":{"table":table,"rowid":rowid ,"row":row},
	"success" : function(data){  if(data){window.location = "'.base_url().'index.php/table/delete_row?table="+table+"&row="+row+"";}}
						});
	}
}
</script></body></html>';
            		
            		       
	          		 $response->rows[$i]['button']= $button;
		       		 array_push($cell, $response->rows[$i]['button']); 	
           		 }
          }
           		 
            $response->rows[$i]['cell'] = $cell;
            $i++;      	 
     
        }
        echo json_encode($response, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
    
    //PP Configuration
    function edit_row(){
    	$table = $_GET["table"];    		
    	$row = $_GET["row"]; 
    	$new_page   =   base_url()."index.php/form/edit/?table=".$table."&row=".$row;
		header("Location: ".$new_page);
    }
    
    //PP Configuration
    function delete_row(){    	
   		$table = $_GET["table"]; 
    	$row = $_GET["row"]; 
    	$new_page   =   base_url()."index.php/form/delete/?table=".$table."&row=".$row;
		header("Location: ".$new_page); 
    }
         

    function decrypt($string)
    {

        $encrypted_string = urldecode($string);
        $encrypted_string = base64_decode($encrypted_string);
        $plaintext_string = $this->encrypt->decode($encrypted_string);
        $output           = trim($plaintext_string);

        return $output;
    }

    function sanitize($data, $enc = true, $param = false)
    {

        if ($param) {
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = stripslashes($data);
        }
        if ($enc) {
            $data = $this->decrypt($data);
        }

        return $data;
    }

    function printPager()
    {
        $dat_d     = date('y-m-d');
        $sortname  = $this->sanitize($_POST['sidx'], false, true);
        $sortorder = $this->sanitize($_POST['sord'], false, true);
        $ddtype    = $this->sanitize($_POST['cell']);


        $title = '';
        if (isset($_POST['title'])) {
            $title = $this->sanitize($_POST['title']);
        }

        $orientation = 'P';
        if (isset($_POST['orientation'])) {
            $orientation = $this->sanitize($_POST['orientation']);
        }

        $saveAsName = $this->sanitize($_POST['save']) . '_' . $dat_d;

        $colHeaders = array();
        if (isset($_POST['colHeaders'])) {
            $colHeaders = $this->sanitize($_POST['colHeaders']);
        }

        $widths = array();
        if (isset($_POST['widths'])) {
            $widths = $this->sanitize($_POST['widths']);;
        }

        $rowid=null;
        if(isset($_POST['rowid'])){
            $rowid  = $this->sanitize($_POST['rowid'], false, true);
        }

        $query  = $this->sanitize($_POST['exec']);

        $hospitalName = "Demo Hospital";
        if (isset($_SESSION["Hospital"])) {
            $hospitalName = $_SESSION["Hospital"];
        }


        if (!($orientation == 'p' || $orientation == 'P' || $orientation == 'l' || $orientation == 'L')) {
            $orientation = 'P';
        }
        $colHeaders = str_replace('[', '', $colHeaders);
        $colHeaders = str_replace(']', '', $colHeaders);
        $colHeaders = str_replace("'", '', $colHeaders);
        $colHeaders = explode(',', $colHeaders);

        $widths = str_replace('[', '', $widths);
        $widths = str_replace(']', '', $widths);
        $widths = str_replace("'", '', $widths);
        $widths = explode(',', $widths);


        $ddtype  = json_decode($ddtype);
        $ddtypes = array();
        foreach ($ddtype as $value) {
            $ddtypes[$value->name] = array("value"  => $value->value, "table" => $value->table,
                                           "column" => $value->column);
        }

        $where = '';
        $split   = preg_split("/GROUP BY/i", $query);
        $query   = isset($split[0])?$split[0]:null;
        $groupBy = isset($split[1])?$split[1]:null;
        if ($groupBy != '') {
            $groupBy = " GROUP BY $groupBy";
        }
        if (stripos($query, 'where') == false) {
            $where .= ' where ';
        } else {
            $where .= ' and ';
        }
        foreach ($ddtypes as $key => $value) {
            unset($searchField);
            if (isset($_POST[$key])) {
                $searchField = $_POST[$key];
            }
            if ($sortname == $key) {
                $sortname = $value['column'];
            }
            if ($value["table"] != '') {
                $key = $value["table"] . '.' . '`' . $value['column'] . '`';
            } else {
                $key = '' . $value['column'] . '';
            }
            if (isset($searchField)) {
                if ($value["value"] == "DDTYPE") {
                    $where .= "$key like '%$searchField%' and ";
                } else {
                    if ($value["value"] == "DSTYPE") {
                        $where .= "$key='$searchField' and ";
                    }
                }
            }
        }
        if (strcasecmp(trim($where), 'where') == 0) {
            $where = '';
        } else {
            $where = substr($where, 0, -4);
        }

        $query .= " $where ";
//meta data
        unset($result);
        $result = $this->db->query($query);
        if (!$sortname) {
            $meta     = mysql_fetch_field($result->result_id, 0);
            $sortname = $meta->name;
        }
        if (!$rowid) {
            $meta  = mysql_fetch_field($result->result_id, 0);
            $rowid = $meta->name;
        }
        if (!$sortorder) {
            $sortorder = 'desc';
        }


        $sort = "ORDER BY `$sortname` $sortorder";

        $query .= "$groupBy $sort ";
        header("Content-type: application/pdf");
        $this->load->library(
            'class/MDSReporter',
            array('orientation' => $orientation, 'unit' => 'mm', 'format' => 'A4', 'footer' => true)
        );
        $pdf = $this->mdsreporter;
        $pdf->writeTitle($hospitalName);
        $pdf->writeSubTitle($title);
        $this->load->model('mpager');
        $pdf = $this->mpager->mysqlReport($pdf, $query, $colHeaders, $widths);
        $pdf->Output($saveAsName, 'I');
        exit;
    }
    

    

 

}

