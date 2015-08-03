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

class Mdrug_stock extends My_Model
{

    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
    
	function get_drug_stock_count($uid){
		$data = array();
		$sql=" select count(drug_stock_id) as total ";
        $sql .= " FROM drug_stock " ;
        $sql .= " WHERE Active = 1 " ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"];   		
	}
	
		
	
	function is_drug_exsist($stock_id=null,$drug_id=null){
		if (($stock_id ==null)||($drug_id==null)){
			return -1;
		}
		$data = array();
		$sql=" select count(drug_count_id) as total ";
        $sql .= " FROM drug_count " ;
        $sql .= " WHERE (drug_stock_id = '$stock_id')  and (who_drug_id='$drug_id')" ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"];   	
	}
	
	
	function deduct_drug($drug_stock_id, $drug_id , $qu){
		$drug_stock_id = stripslashes($drug_stock_id);
        $drug_stock_id = mysql_real_escape_string($drug_stock_id);
		$drug_id = stripslashes($drug_id);
        $drug_id = mysql_real_escape_string($drug_id);
		$qu = stripslashes($qu);
        $qu = mysql_real_escape_string($qu);
		$sql=" UPDATE drug_count
			SET who_drug_count=who_drug_count-$qu
			WHERE (drug_stock_id='$drug_stock_id') AND (who_drug_id='$drug_id')" ;
        $Q =  $this->db->query($sql);
		
	}
	
	
	function get_drug_stock_info($drug_stock_id){
		$drug_stock_id = stripslashes($drug_stock_id);
        $drug_stock_id = mysql_real_escape_string($drug_stock_id);
		$dataset = array();
		$sql=" select drug_stock.* ";
        $sql .= " FROM  drug_stock " ;
        $sql .= " WHERE drug_stock.drug_stock_id = '$drug_stock_id'" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
            foreach ($Q->result_array() as $row){
                $dataset= $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}		
	function get_drug_count_list($stock_id){
		$dataset = array();
		$sql=" select drug_count.drug_count_id,drug_count.who_drug_count,drug_count.Active , who_drug.name, who_drug.formulation,who_drug.dose";
        $sql .= " FROM  drug_count " ;
		$sql .=" LEFT JOIN `who_drug` ON who_drug.wd_id = drug_count.who_drug_id ";
        $sql .= " WHERE (drug_count.Active = '1') and (drug_count.drug_stock_id='$stock_id') order by who_drug.name " ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 			
	}	
	function get_who_drug_list(){
		$dataset = array();
		$sql=" select wd_id ";
        $sql .= " FROM  who_drug " ;
        //$sql .= " WHERE who_drug.Active = '1' " ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 		
	}
	
	function get_drug_stock_list(){
		$dataset = array();
		$sql=" select drug_stock.* ";
        $sql .= " FROM  drug_stock " ;
        if ($this->config->item('purpose') !="PP"){	
        	$sql .= " WHERE drug_stock.Active = '1' " ;
        }else{
        	$sql .= " WHERE drug_stock.Active = '1' AND  drug_stock_id=1" ;
        }
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
