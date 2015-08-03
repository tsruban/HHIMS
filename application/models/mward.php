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

class Mward extends My_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table = 'ward';
        $this->_key = 'WID';
		$this->load->database();
    }
			
	function get_patient_list($wid){
	$wid = stripslashes($wid);
        $wid = mysql_real_escape_string($wid);
		$dataset = array();
		$sql=" SELECT 
	  admission.ADMID,
	  admission.BHT,
	  patient.HIN as HIN,
	  patient.Gender ,
	  patient.DateOfBirth ,
	  CONCAT(patient.Personal_Title, ' ' ,patient.Full_Name_Registered,' ', patient.Personal_Used_Name) as patient_name ,
	  admission.AdmissionDate,
	  admission.Complaint,
	  admission_prescription.admission_prescription_id 
	  from admission 
	  LEFT JOIN `patient` ON patient.PID = admission.PID 
	  LEFT JOIN `admission_prescription` ON admission_prescription.ADMID = admission.ADMID 
	  where (admission.Active =1) and (admission.Ward= '$wid')
	   and (admission.OutCome is null)
			" ;
        $Q =  $this->db->query($sql);
		foreach ($Q->result_array() as $row) {
			$dataset[] = $row;
		}

        $Q->free_result();    
        return $dataset; 		
	}		
	function get_dispense_info($pitem_id,$dte){
			$pitem_id = stripslashes($pitem_id);
        $pitem_id = mysql_real_escape_string($pitem_id);
		$dataset = array();
		$sql=" select admission_prescribe_items_dispense.* ";
        $sql .= " FROM  admission_prescribe_items_dispense " ;
        $sql .= " WHERE admission_prescribe_items_dispense.prescribe_items_id = '$pitem_id' 
			and admission_prescribe_items_dispense.given_date_time like '$dte%'
		" ;
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
		function get_prescribe_items($prsid,$typ=null){
		$prsid = stripslashes($prsid);
        $prsid = mysql_real_escape_string($prsid);
		$dataset = array();
		$sql=" select admission_prescribe_items.*, ";
		$sql .="  who_drug.name, who_drug.formulation, who_drug.dose ";
        $sql .= " FROM  admission_prescribe_items " ;
        $sql .= " LEFT JOIN `who_drug` ON who_drug.wd_id = admission_prescribe_items.DRGID  " ;
		
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
	
    function get_total_active_record(){
		$data = array();
		$sql=" select count(WID) as total ";
        $sql .= " FROM ward " ;
        //$sql .= " WHERE Active = 1 " ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"];    
    }

    function getAdmissionsByDate($date){
        if($this->WID){
            $where=array('Ward'=>$this->WID,'AdmissionDate like'=>$date.'%');
            return $this->db->get_where('admission',$where);
        }else{
            null;
        }
    }

    function getPreviousMidnightBalance($date){
        if($this->WID){
            $date=date('Y-m-d', strtotime('-1 day', strtotime($date)));
            $where=array('Ward'=>$this->WID,'AdmissionDate like'=>$date.'%');
            return $this->db->get_where('admission',$where);
        }else{
            null;
        }
    }

    function getTransfersIn($date){
        if($this->WID){
            $where=array('TransferTo'=>$this->WID,'TransferDate like'=>$date.'%');
            return $this->db->get_where('admission_transfer',$where);
        }else{
            null;
        }
    }

    function getTransfersOut($date){
        if($this->WID){
            $where=array('TransferFrom'=>$this->WID,'TransferDate like'=>$date.'%');
            return $this->db->get_where('admission_transfer',$where);
        }else{
            null;
        }
    }

    function getDischarges($date){
        if($this->WID){
            $where=array('Ward'=>$this->WID,'AdmissionDate like'=>$date.'%','OutCome !='=>'');
            return $this->db->get_where('admission',$where);
        }else{
            null;
        }
    }

    function getDeathsGt($date){
        if($this->WID){
            $date=date('Y-m-d', strtotime('+2 day', strtotime($date)));
            $where=array('Ward'=>$this->WID,'AdmissionDate like'=>$date.'%','OutCome ='=>'Died','DischargeDate <'=>$date);
            return $this->db->get_where('admission',$where);
        }else{
            null;
        }
    }

    function getDeathsLt($date){
        if($this->WID){
            $date=date('Y-m-d', strtotime('+2 day', strtotime($date)));
            $where=array('Ward'=>$this->WID,'AdmissionDate like'=>$date.'%','OutCome ='=>'Died','DischargeDate >'=>$date);
            return $this->db->get_where('admission',$where);
        }else{
            null;
        }
    }


}
