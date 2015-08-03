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

class Mclinic extends My_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table = 'clinic';
        $this->_key = 'clinic_id';
        $this->load->database();
    }
	
    function get_total_active_record(){
		$data = array();
		$sql=" select count(clinic_patient_id) as total ";
        $sql .= " FROM clinic_patient " ;
        //$sql .= " WHERE Active = 1 " ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"];    
    }
	
	function count_question($quest_id, $qid){
		$data = array();
		$sql=" select count(qu_question_id) as total ";
        $sql .= " FROM qu_question " ;
        $sql .= " WHERE (qu_questionnaire_id = $quest_id) and (qu_question_repos_id = $qid) " ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"];    
	}	
	function count_all_question($quest_id){
		$data = array();
		$sql=" select count(qu_question_id) as total ";
        $sql .= " FROM qu_question " ;
        $sql .= " WHERE (qu_questionnaire_id = $quest_id)  " ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"];    
	}
	
	function get_patient_clinic_list($pid=null){
		$dataset = array();
		$pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
		$dataset = array();
		$sql=" SELECT *  ";
        $sql .= " FROM clinic_patient ";
		$sql .= " WHERE (PID = '$pid' )";

		$sql .= " and (Active=1) " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 
	}
	function get_clinic_list($gender){
		$dataset = array();
		$gender = stripslashes($gender);
        $gender = mysql_real_escape_string($gender);
		$sql=" SELECT *  ";
        $sql .= " FROM clinic ";
		$sql .= " WHERE (1=1)";
		if ($gender != "Both"){
			$sql .= " and ((applicable_to='$gender') OR (applicable_to='Both'))" ;
		}
		$sql .= " and (Active=1) " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 
	}
	function is_patient_assigned($pid,$clinic_id){
		$data = array();
		$pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
		$clinic_id = stripslashes($clinic_id);
        $clinic_id = mysql_real_escape_string($clinic_id);
		$dataset = array();
		$sql=" SELECT *  ";
        $sql .= " FROM clinic_patient ";
		$sql .= " WHERE (PID = '$pid' )";
		$sql .= " and (clinic_id='$clinic_id') " ;
		$sql .= " and (status='Refered') " ;
		$sql .= " and (Active=1) " ;
        $Q =  $this->db->query($sql);
		if ($Q->num_rows() == 1){
            $data = $Q->row_array();
        }
		$Q->free_result();    
        return $data; 	
	}
	
	
	function get_prescribe_items($prsid){
		$prsid = stripslashes($prsid);
        $prsid = mysql_real_escape_string($prsid);
		$dataset = array();
		$sql=" select clinic_prescribe_items.* ";
        $sql .= " FROM  clinic_prescribe_items " ;
        $sql .= " WHERE clinic_prescribe_items.clinic_prescription_id = '$prsid'" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}	
	
	function get_clinic_info($id){
		$data = array();
		$id = stripslashes($id);
        $id = mysql_real_escape_string($id);
		$sql=" SELECT *  ";
        $sql .= " FROM clinic WHERE clinic_id='$id' " ;
		
        $Q =  $this->db->query($sql);
        //echo "<br />".$this->db->last_query();
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    
        return $data;   
	}	
	

}
