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

class Mnotification extends My_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table = 'notification';
        $this->_key = 'NOTIFICATION_ID';
        $this->load->database();
    }
	function is_complaint_notify($complaint){
		$complaint = stripslashes($complaint);
        $complaint = mysql_real_escape_string($complaint);
		$dataset = array();
		$sql=" select complaints.* ";
        $sql .= " FROM  complaints " ;
        $sql .= " WHERE complaints.Name = '$complaint' " ;
        $sql .= " and complaints.isNotify = '1' " ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() ==1){
            foreach ($Q->result_array() as $row){
                $dataset = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 		
	}
	function is_opd_notifed($OPDID){
		$OPDID = stripslashes($OPDID);
        $OPDID = mysql_real_escape_string($OPDID);
		$dataset = array();
		$sql=" select notification.* ";
        $sql .= " FROM  notification " ;
        $sql .= " WHERE notification.EPISODEID = '$OPDID' " ;
        $sql .= " and notification.Episode_Type = 'opd' " ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() ==1){
            foreach ($Q->result_array() as $row){
                $dataset = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 		
	}
    function get_total_active_record()
    {
        $data = array();
        $sql = " select count(NOTIFICATION_ID) as total ";
        $sql .= " FROM notification ";
        //$sql .= " WHERE Active = 1 " ;

        $Q = $this->db->query($sql);
        if ($Q->num_rows() > 0) {
            $data = $Q->row_array();
        }
        $Q->free_result();

        return $data["total"];
    }


}
