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

class Mquestionnaire extends CI_Model
{

    function __construct()
    {
        parent::__construct();
		$this->load->database();
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
		/*
	$sql = "SELECT *,qu_question_repos.question FROM `qu_answer` \n"
    . "LEFT JOIN `qu_question_repos` ON qu_question_repos.qu_question_repos_id = qu_answer.`qu_question_id`\n"
    . "WHERE (`qu_quest_answer_id`=44437037) LIMIT 0, 30 ";
	*/
	
	function get_clinic_questionnaire_list($clinic_id){
		$dataset = array();
		$clinic_id = stripslashes($clinic_id);
        $clinic_id = mysql_real_escape_string($clinic_id);
		$dataset = array();
		$sql=" SELECT *  ";
        $sql .= " FROM qu_questionnaire ";
		$sql .= " WHERE (1=1)";
		$sql .= "  and (show_in_clinic='$clinic_id')  ";
		$sql .= " and (Active=1) order by code" ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 
	}
	
	function get_clinic_previous_record_list($clinic_patient_id,$from,$to){
		$dataset = array();
		$clinic_patient_id = stripslashes($clinic_patient_id);
        $clinic_patient_id = mysql_real_escape_string($clinic_patient_id);
		$sql=" SELECT qu_quest_answer.* ,qu_questionnaire.name as qu_name ";
        $sql .= " FROM qu_quest_answer ";
		$sql .= " LEFT JOIN `qu_questionnaire` ON qu_questionnaire.qu_questionnaire_id = qu_quest_answer.qu_questionnaire_id ";
		$sql .= " WHERE (1=1) and (qu_quest_answer.link_type = 'clinic_patient')";
		$sql .= "  and (qu_quest_answer.link_id='$clinic_patient_id')  ";
		$sql .= " and (qu_quest_answer.Active=1) order by qu_quest_answer.CreateDate DESC " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 	
	}
	
	function get_clinic_patient_answer_list($quest_ans_id){
		$dataset = array();
		$quest_ans_id = stripslashes($quest_ans_id);
        $quest_ans_id = mysql_real_escape_string($quest_ans_id);
		$dataset = array();
		$sql = "SELECT qu_answer_id,qu_answer.qu_question_id,answer,answer_type,question_type,qu_question_repos.question FROM `qu_answer` \n"
    . "LEFT JOIN `qu_question_repos` ON qu_question_repos.qu_question_repos_id = qu_answer.`qu_question_id` \n"
    //. "LEFT JOIN `qu_question` ON qu_question.qu_question_repos_id = qu_question_repos.`qu_question_repos_id` \n"
    . "WHERE (`qu_quest_answer_id`='$quest_ans_id')  order by qu_answer.answer_order";
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 
	}
	
	function get_questionnaire_list($typ){
		$dataset = array();
		$typ = stripslashes($typ);
        $typ = mysql_real_escape_string($typ);
		$dataset = array();
		$sql=" SELECT *  ";
        $sql .= " FROM qu_questionnaire ";
		$sql .= " WHERE (1=1)";
		if ($typ == "patient"){
			$sql .= "  and (show_in_patient=1)  ";
		}
		if ($typ == "admission"){
			$sql .= "  and (show_in_admission=1)  ";
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
	
	function questionnaire_list($id){
		$dataset = array();
		$id = stripslashes($id);
        $id = mysql_real_escape_string($id);
		$dataset = array();
		$sql=" SELECT *  ";
        $sql .= " FROM qu_questionnaire WHERE qu_module_id='$id' " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 
	}	
	function get_question_list($id){
		$dataset = array();
		$id = stripslashes($id);
        $id = mysql_real_escape_string($id);
		$dataset = array();
		$sql=" SELECT qu_question_repos.*,qu_question.qu_question_id, qu_question.show_order ";
        $sql .= " FROM qu_question ";
		$sql .=" LEFT JOIN `qu_question_repos` ON qu_question_repos.qu_question_repos_id = qu_question.qu_question_repos_id ";
		 $sql .= "WHERE qu_question.qu_questionnaire_id='$id' order by qu_question.show_order" ;
        //$sql .= " order by  qu_question.order" ;
		//echo $sql.'<br>';
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 
	}	

	function get_select_data($qid){
		$dataest = array();
		$qid = stripslashes($qid);
        $qid = mysql_real_escape_string($qid);
		$dataset = array();
		$sql=" SELECT *  ";
        $sql .= " FROM qu_select WHERE qu_select.qu_question_id='$qid' " ;
        $sql .= " and qu_select.active='1' " ;
        $sql .= " order by  qu_select.select_value" ;
		//echo $sql.'<br>';
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 
	}
	function get_diagram_info($qid){
		$qid = stripslashes($qid);
        $qid = mysql_real_escape_string($qid);
		$data = array();
		$sql=" SELECT *  ";
        $sql .= " FROM qu_diagram WHERE qu_diagram.qu_question_id='$qid' " ;
        $sql .= " and qu_diagram.active='1' " ;
		//echo $sql.'<br>';
		//exit;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
		$Q->free_result();    
        return $data; 
	}
	function get_module_info($id){
		$data = array();
		$id = stripslashes($id);
        $id = mysql_real_escape_string($id);
		$sql=" SELECT *  ";
        $sql .= " FROM qu_module WHERE qu_module_id='$id' " ;
		
        $Q =  $this->db->query($sql);
        //echo "<br />".$this->db->last_query();
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    
        return $data;   
	}	
	function get_questionnaire_info($id){
		$data = array();
		$id = stripslashes($id);
        $id = mysql_real_escape_string($id);
		$sql=" SELECT qu_questionnaire.*, qu_module.name as mname,qu_module.code as mcode, qu_module.qu_module_id as qu_module_id  ";
        $sql .= " FROM qu_questionnaire ";
		$sql .=" LEFT JOIN `qu_module` ON qu_module.qu_module_id = qu_questionnaire.qu_module_id ";
		$sql .= " WHERE qu_questionnaire.qu_questionnaire_id='$id' " ;
		
        $Q =  $this->db->query($sql);
        //echo "<br />".$this->db->last_query();
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    
        return $data;   
	}

}
