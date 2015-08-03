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

class Mopd extends My_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table = 'opd_visits';
        $this->_key = 'OPDID';
		$this->load->database();
    }
	function get_favour_drug_count($uid){
		$uid = stripslashes($uid);
        $uid = mysql_real_escape_string($uid);
		$data = array();
		$sql=" select count(user_favour_drug_id) as total ";
        $sql .= " FROM user_favour_drug " ;
        $sql .= " WHERE Active = 1 " ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"];   		
	}
	function get_last_prescription($opd_id){
		$opd_id = stripslashes($opd_id);
        $opd_id = mysql_real_escape_string($opd_id);
		$dataset = array();
		$sql=" select Max(opd_presciption.PRSID) as PRSID ";
        $sql .= " FROM  opd_presciption " ;
        $sql .= " WHERE (opd_presciption.Status = 'Dispensed') " ;
       // $sql .= " WHERE (opd_presciption.OPDID = '$opd_id') and((opd_presciption.Status = 'Dispensed')) " ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
            $dataset = $Q->row_array();
        }
        $Q->free_result();    
        return $dataset; 	
	}		
	
	function get_opd_presciption_info($opd_id){
		return null;
	}		
	
    function get_previous_notes_list($opdid)
    {
		$opdid = stripslashes($opdid);
        $opdid = mysql_real_escape_string($opdid);
        $dataset = array();
		$sql=" SELECT opd_notes.opd_notes_id,opd_notes.notes,opd_notes.CreateDate,opd_notes.CreateUser ";
        $sql .= " FROM opd_notes ";
		$sql .= " WHERE (1=1) and (opd_notes.OPDID = '$opdid')";
		$sql .= " order by opd_notes.CreateDate DESC " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 	
    }	
	
	function get_drug_list ($prsid,$stock_id){
		$dataset = array();
		$sql=" select prescribe_items.PRES_ID, who_drug.name,who_drug.dose,who_drug.formulation ,prescribe_items.DRGID as wd_id,prescribe_items.frequency,prescribe_items.HowLong ,drug_count.who_drug_count ";
        $sql .= " FROM prescribe_items" ;
		$sql .=" LEFT JOIN `who_drug` ON who_drug.wd_id = prescribe_items.DRGID ";
		$sql .=" left JOIN `drug_count` ON drug_count.who_drug_id= who_drug .wd_id";
        $sql .= " WHERE (prescribe_items.PRES_ID ='$prsid') and ( prescribe_items.Active)
			and ( drug_count.drug_stock_id = '$stock_id')
		" ;
		
	   $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}
	
	function get_prescribe_items($prsid){
		$prsid = stripslashes($prsid);
        $prsid = mysql_real_escape_string($prsid);
		$dataset = array();
		$sql=" select prescribe_items.* ";
        $sql .= " FROM  prescribe_items " ;
        $sql .= " WHERE prescribe_items.PRES_ID = '$prsid'" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}	
	function get_stock_info($visit_type_id){
		$visit_type_id = stripslashes($visit_type_id);
        $visit_type_id = mysql_real_escape_string($visit_type_id);
		$dataset = array();
		$sql=" select drug_stock.* ";
        $sql .= " FROM  visit_type " ;
		$sql .=" LEFT JOIN `drug_stock` ON drug_stock.drug_stock_id = visit_type.Stock ";
        $sql .= " WHERE visit_type.VTYPID = '$visit_type_id'" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() ==1){
            foreach ($Q->result_array() as $row){
                $dataset = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}
	function get_info($opd_id){
		$opd_id = stripslashes($opd_id);
        $opd_id = mysql_real_escape_string($opd_id);
		$dataset = array();
		$sql=" select opd_visits.*,visit_type.VTYPID as visit_type_id,visit_type.Name as visit_type_name,opd_visits.Doctor as doc_id, concat(user.Title,user.FirstName,' ',user.OtherName ) as Doctor ";
        $sql .= " FROM  opd_visits " ;
		$sql .=" LEFT JOIN `user` ON user.UID = opd_visits.Doctor ";
		$sql .=" LEFT JOIN `visit_type` ON visit_type.VTYPID = opd_visits.VisitType ";
        $sql .= " WHERE opd_visits.OPDID = '$opd_id'" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() ==1){
            foreach ($Q->result_array() as $row){
                $dataset = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}	

}
