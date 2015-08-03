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

class Mpatient extends My_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table = 'patient';
        $this->_key = 'PID';
        $this->load->database();
    }

    
    
    function get_previous_injection_list($pid)
    {
		$pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
        $dataset = array();
		$sql=" SELECT patient_injection.episode_id,patient_injection.episode_type,patient_injection.patient_injection_id,patient_injection.CreateDate,patient_injection.status,injection.name,injection.dosage,injection.injection_id, injection.route ";
        $sql .= " FROM patient_injection ";
		$sql .= " LEFT JOIN `injection` ON injection.injection_id = patient_injection.injection_id ";
		$sql .= " WHERE (1=1) and (patient_injection.PID = '$pid')";
		$sql .= " order by patient_injection.CreateDate DESC " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 	
    }
	
	function get_notes_list($pid,$tbl=null)
    {
		$pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
        $dataset = array();
		if ($tbl == "patient"){
			$sql=" SELECT patient_notes.notes,patient_notes.CreateDate,patient_notes.CreateUser ";
			$sql .= " FROM patient_notes ";
			$sql .= " WHERE (1=1) and (patient_notes.PID = '$pid')";
			$sql .= " order by patient_notes.CreateDate DESC " ;
		}
		else if ($tbl == "opd"){
			$sql=" SELECT opd_notes.notes,opd_notes.CreateDate,opd_notes.CreateUser ";
			$sql .= " FROM opd_notes ";
			$sql .= " LEFT JOIN `opd_visits` ON opd_visits.OPDID = opd_notes.OPDID ";
			$sql .= " WHERE (1=1)  and opd_visits.PID = '$pid'";
			$sql .= " order by opd_notes.CreateDate DESC " ;
		}
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 	
    }
	
    function get_previous_notes_list($pid)
    {
		$pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
        $dataset = array();
		$sql=" SELECT patient_notes.notes,patient_notes.CreateDate,patient_notes.CreateUser ";
        $sql .= " FROM patient_notes ";
		$sql .= " WHERE (1=1) and (patient_notes.PID = '$pid')";
		$sql .= " order by patient_notes.CreateDate DESC " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 	
    }

    function get_all_patient()
    {
        $dataset = array();
        $sql = " select PID ";
        $sql .= " FROM patient ";

        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }


    function get_total_active_patient()
    {
        $data = array();
        $sql = " select count(PID) as total ";
        $sql .= " FROM patient ";
        //$sql .= " WHERE Active = 1 " ;

        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            $data = $Q->row_array();
        }
        $Q->free_result();

        return $data["total"];
    }
	function patient_previous_lab_list($pid){
        $pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
        $dataset = array();
        $sql = " select distinct(lab_order.TestGroupName) ,lab_test_group.LABGRPTID ";
        $sql .= " FROM lab_order ";
		$sql .= " LEFT JOIN `lab_test_group` ON lab_test_group.Name = lab_order.TestGroupName ";
        $sql .= " WHERE (lab_order.Active = 1) and (lab_order.PID='$pid') order by lab_order.TestGroupName ";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;	
	}
    function get_allergy_list($pid)
    {
        $pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
        $dataset = array();
        $sql = " select * ";
        $sql .= " FROM patient_alergy ";
        $sql .= " WHERE (Active = 1) and (PID='$pid') order by CreateDate desc";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }

    public function get_exams_list($pid)
    {
        $pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
        $dataset = array();
        $sql = " SELECT * FROM patient_exam WHERE pid = '" . $pid . "' ORDER BY ExamDate DESC LIMIT 0,10";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }

    public function get_history_list($pid)
    {
        $pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
        $dataset = array();
        $sql = " SELECT * FROM patient_history WHERE PID = '" . $pid . "' ORDER BY HistoryDate DESC ";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }

    public function get_lab_order_list($pid)
    {
        $pid = stripslashes($pid);
        $pid = mysql_real_escape_string($pid);
        $dataset = array();
        $sql = " SELECT * FROM lab_order WHERE PID = '" . $pid . "' ORDER BY OrderDate DESC";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }

    public function get_prescription_list($opd_id)
    {
        $opd_id = stripslashes($opd_id);
        $opd_id = mysql_real_escape_string($opd_id);
        $dataset = array();
        $sql
            = "SELECT distinct
	opd_presciption.PRSID,
	opd_presciption.Status,
  opd_presciption.CreateDate,
  opd_presciption.PrescribeBy
FROM opd_presciption
  
WHERE opd_presciption.Active = 1 AND
 opd_presciption.OPDID = $opd_id";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }

    public function get_treatment_list($opd_id)
    {
        $opd_id = stripslashes($opd_id);
        $opd_id = mysql_real_escape_string($opd_id);
        $dataset = array();
        $sql = " SELECT * FROM opd_treatment WHERE OPDID = '" . $opd_id . "' ORDER BY CreateDate DESC ";
        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $dataset[] = $row;
            }
        }
        $Q->free_result();
        return $dataset;
    }

    function getAge()
    {
        $date = new DateTime($this->DateOfBirth);
        $now = new DateTime();
        $interval = $now->diff($date);
        return $interval->y . 'Y' . $interval->m . 'M' . $interval->d . 'D';
    }

    function getAddress()
    {
        $address = $this->getValue("Address_Village") . ",";
        $address .= $this->getValue("Address_DSDivision") . ",";
        $address .= $this->getValue("Address_District");
        return $address;
    }


}
