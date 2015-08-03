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

class Madmission extends My_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table = 'admission';
        $this->_key = 'ADMID';
		$this->load->database();
    }

	function get_stock_list(){
		$dataset = array();
		$sql=" select drug_stock.drug_stock_id, drug_stock.name ";
        $sql .= " FROM  drug_stock " ;
        $sql .= " WHERE drug_stock.Active = 1" ;
        $Q =  $this->db->query($sql);
		foreach ($Q->result_array() as $row) {
			$dataset[] = $row;
		}

        $Q->free_result();    
        return $dataset; 		
	}
	
    function get_notes_list($admid)
    {
		$admid = stripslashes($admid);
        $admid = mysql_real_escape_string($admid);
        $dataset = array();
		$sql=" SELECT admission_notes.ADMNOTEID,admission_notes.Note,admission_notes.CreateDate,admission_notes.CreateUser ";
        $sql .= " FROM admission_notes ";
		$sql .= " WHERE (1=1) and (admission_notes.ADMID = '$admid')";
		$sql .= " order by admission_notes.CreateDate DESC " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 	
    }	
	
	function get_info($adm_id){
		$adm_id = stripslashes($adm_id);
        $adm_id = mysql_real_escape_string($adm_id);
		$dataset = array();
		$sql=" select admission.*, concat(user.Title,user.FirstName,' ',user.OtherName ) as Doctor , ward.Name as Ward, ward.WID as WID ";
        $sql .= " FROM  admission " ;
		$sql .=" LEFT JOIN `user` ON user.UID = admission.Doctor ";
		$sql .=" LEFT JOIN `ward` ON ward.WID = admission.Ward ";
        $sql .= " WHERE admission.ADMID = '$adm_id'" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() ==1){
            foreach ($Q->result_array() as $row){
                $dataset = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}	
	    public function get_drug_order($admid)  {
        $admid = stripslashes($admid);
        $admid = mysql_real_escape_string($admid);
        $dataset = array();
        $sql
            = "SELECT DISTINCT admission_prescription.admission_prescription_id, admission_prescription.Status, admission_prescription.CreateDate, admission_prescription.PrescribeBy
			FROM admission_prescription
			WHERE admission_prescription.Active =1
			AND admission_prescription.ADMID =$admid
			ORDER BY admission_prescription.admission_prescription_id DESC 
			LIMIT 0 , 1";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }
	
	    public function get_drug_order_list($order_id)  {
        $order_id = stripslashes($order_id);
        $order_id = mysql_real_escape_string($order_id);
        $dataset = array();
        $sql
            = "SELECT admission_prescribe_items.*, who_drug.name,who_drug.dose,who_drug.formulation 
			FROM admission_prescribe_items
			LEFT JOIN `who_drug` ON who_drug.wd_id = admission_prescribe_items.DRGID
			WHERE admission_prescribe_items.Active =1
			AND admission_prescribe_items.admission_prescription_id =$order_id order by `type` desc"
			;
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }	
	
	public function get_diagnosis_list($admid)
    {
        $admid = stripslashes($admid);
        $admid = mysql_real_escape_string($admid);
        $dataset = array();
        $sql = " SELECT * FROM admission_diagnosis WHERE (ADMID = '" . $admid . "') ";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }
	
    public function get_lab_order_list($admid)
    {
        $admid = stripslashes($admid);
        $admid = mysql_real_escape_string($admid);
        $dataset = array();
        $sql = " SELECT * FROM lab_order WHERE (OBJID = '" . $admid . "') and(Dept='ADM') ORDER BY OrderDate DESC";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }
	function get_prescribe_items($prsid,$typ=null){
		$prsid = stripslashes($prsid);
        $prsid = mysql_real_escape_string($prsid);
		$dataset = array();
		$sql=" select admission_prescribe_items.* ";
        $sql .= " FROM  admission_prescribe_items " ;
        $sql .= " WHERE admission_prescribe_items.admission_prescription_id = '$prsid' " ;
		if ($typ){
		$sql .= " and admission_prescribe_items.type = '$typ' order by `type` desc" ;
		}
		
		//
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}
	

	function dispence_data($pitem_id=null){
		$pitem_id = stripslashes($pitem_id);
        $pitem_id = mysql_real_escape_string($pitem_id);
		$dataset = array();
		$sql=" select admission_prescribe_items_dispense.* ";
        $sql .= " FROM  admission_prescribe_items_dispense " ;
        $sql .= " WHERE admission_prescribe_items_dispense.prescribe_items_id = '$pitem_id' order by `given_date_time` " ;
		//
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}	
}
