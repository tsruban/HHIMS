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

class Mlaboratory extends CI_Model
{

    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

    function get_total_active_record(){
		$data = array();
		$sql=" select count(LAB_ORDER_ID) as total ";
        $sql .= " FROM lab_order " ;
        //$sql .= " WHERE Active = 1 " ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"];    
    }
	
	function get_ordered_lab_test($lab_id){
		$lab_id = stripslashes($lab_id);
        $lab_id = mysql_real_escape_string($lab_id);
		$dataset = array();
		$sql=" select lab_order_items.LAB_ORDER_ITEM_ID ,
		lab_order_items.CreateDate,
		lab_order_items.Status,
		lab_order_items.TestValue,
		lab_order_items.CreateUser,
		lab_tests.Name,
		lab_tests.RefValue
		";
        $sql .= " FROM lab_order_items " ;
		$sql .= " LEFT JOIN `lab_tests` ON lab_tests.LABID = lab_order_items.LABID ";
        $sql .= " WHERE (lab_order_items.Active = 1) and (lab_order_items.LAB_ORDER_ID = '$lab_id')" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  	
	
	}
	
	function get_lab_test($grp){
		$grp = stripslashes($grp);
        $grp = mysql_real_escape_string($grp);
		$dataset = array();
		$sql=" select LABID ,Name,GroupName,Department  ";
        $sql .= " FROM lab_tests " ;
        $sql .= " WHERE (Active = 1) and (GroupName = '$grp')" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  	
	}
	function get_test_list(){
        $dataset = array();
		$sql=" SELECT Name, LABGRPTID ";
        $sql .= " FROM lab_test_group ";
		$sql .= " WHERE (Active=1) ";
		$sql .= " order by Name " ;
        $Q =  $this->db->query($sql);
		 if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
		$Q->free_result();    
        return $dataset; 		
	}

    function get_ordered_lab_item($lab_item_id){
        $lab_item_id = stripslashes($lab_item_id);
        $lab_item_id = mysql_real_escape_string($lab_item_id);
        $dataset = array();
        $sql=" select lab_order_items.LAB_ORDER_ITEM_ID ,
		lab_order_items.CreateDate,
		lab_order_items.Status,
		lab_order_items.TestValue,
		lab_order_items.CreateUser,
		lab_tests.Name,
		lab_tests.RefValue
		";
        $sql .= " FROM lab_order_items " ;
        $sql .= " LEFT JOIN `lab_tests` ON lab_tests.LABID = lab_order_items.LABID ";
        $sql .= " WHERE (lab_order_items.Active = 1) and (lab_order_items.LAB_ORDER_ITEM_ID = '$lab_item_id')" ;
        $Q =  $this->db->query($sql);
        $dataset=$Q->row();
        $Q->free_result();
        return $dataset;

    }
	
	function get_episode_lab_order(	$ep_id,$dept=null){
		$ep_id = stripslashes($ep_id);
        $ep_id = mysql_real_escape_string($ep_id);
		if (($dept == "OPD")
			||($dept == "ADM")
			||($dept == "CLN"))
		{
				$dataset = array();
				$sql=" select lab_order.LAB_ORDER_ID ,
				lab_order.TestGroupName ,
				lab_order.Status ,
				lab_order.OrderDate
				";
				$sql .= " FROM lab_order " ;
				$sql .= " WHERE (lab_order.Active = 1) and (lab_order.Dept = '$dept') and (lab_order.OBJID = '$ep_id')" ;
				$Q =  $this->db->query($sql);
				if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
						$dataset[] = $row;
					}
				}
				$Q->free_result();
				return $dataset;			
		}
		else{
			return null;
		}
	}

}
