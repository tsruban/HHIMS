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
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/

class Mmenu extends CI_Model
{

    function __construct()
    {
        parent::__construct();
		$this->load->database();
		
    }

    function get_menu_list($ug){
        $dataset = array();
		
		$sql  = "SELECT Name, Link,UMID ";
		$sql .= " FROM user_menu WHERE Active = TRUE and UserGroup REGEXP '".$ug."'  " ;
		$sql .= " ORDER BY MenuOrder";

        $Q =  $this->db->query($sql);
        //echo "<br />".$this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        //print_r($data);
        return $dataset;    
    }

    //PP confiduration, the top menu will be different
    function get_menu_list_for_PP($ug){
        $dataset = array();
		
		$sql  = "SELECT Name, Link,UMID ";
		$sql .= " FROM user_menu WHERE Active = TRUE and UserGroup REGEXP '".$ug."'  " ;
		$sql .= "AND PP_Menu = 1 ORDER BY MenuOrder";
		
        $Q =  $this->db->query($sql);
        //echo "<br />".$this->db->last_query();
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        //print_r($data);
        return $dataset;    
    }
    
	
	function get_home_menu($ug){
        $data = array();
		$sql  = "SELECT MainMenu ";
		$sql .= " FROM user_group WHERE Active = TRUE and Name ='".$ug."'  " ;
	// die(print_r($sql));
        $Q =  $this->db->query($sql);
        //echo "<br />".$this->db->last_query();
        if ($Q->num_rows() > 0){
                $data= $Q->row_array();;
        }
        $Q->free_result();    
        //print_r($data);
        return $data;    
    }
}
