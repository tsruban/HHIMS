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

class Mlogin extends CI_Model
{

    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

    function do_auth($username,$password=NULL){
        $data = array();
		$username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = md5(mysql_real_escape_string($password));
		$sql=" SELECT *  ";
        $sql .= " FROM user WHERE user.UserName='$username' and user.Password='$password'  " ;
        $sql .= " and user.Active = 1 " ;
		
        $Q =  $this->db->query($sql);
        //echo "<br />".$this->db->last_query();
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    
        //print_r($data);
        return $data;    
    }

    function get_hospital($hid){
        $data = array();
		$sql=" SELECT *  ";
        $sql .= " FROM hospital WHERE HID = ".$hid ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    
        return $data;    
    }
	function set_online($uid){
		if (!$uid) return FALSE;
		$data = array("Status"=>"ON_LINE","LastTimeSeen"=>date("Y-m-d H:i:s"));
		$this->db->where("UID", $uid);
		$this->db->update("user", $data); 
		return true;
	}
	function set_offline($uid){
		if (!$uid) return FALSE;
		$data = array("Status"=>"OFF_LINE","LastTimeSeen"=>date("Y-m-d H:i:s"));
		$this->db->where("UID", $uid);
		$this->db->update("user", $data); 
		return true;
	}
	function set_logout($uid){
		if (!$uid) return FALSE;
		$data = array("Status"=>"LOGGED_OUT","LastTimeSeen"=>date("Y-m-d H:i:s"));
		$this->db->where("UID", $uid);
		$this->db->update("user", $data); 
		return true;
	}
}
