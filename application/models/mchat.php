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

class Mchat extends CI_Model
{

    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }

    function get_online_user_list($uid){
		$uid = stripslashes($uid);
        $uid = mysql_real_escape_string($uid);
		$dataset = array();
		$sql=" select UID,Status,FirstName,OtherName,UserName ";
        $sql .= " FROM user " ;
        $sql .= " WHERE ((Active = 1) and (Status <> 'LOGGED_OUT') and (LastTimeSeen >= DATE_SUB(NOW(), INTERVAL 1 DAY))) OR (UID='$uid')" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;    
    }
	function get_new_message($user_id){
		$uid = stripslashes($user_id);
        $uid = mysql_real_escape_string($uid);
		$data = array();
		$sql=" select count(CHAT_MESSAGE_ID) as total";
        $sql .= " FROM  user_chat_message " ;
        $sql .= " WHERE TO_ID = '$user_id' and  Seen = 0" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    

        return $data["total"]; 
	}
	function check_message($user_id){
		$uid = stripslashes($user_id);
        $uid = mysql_real_escape_string($uid);
		$dataset = array();
		$sql=" select user_chat_message.*, user.UserName as FromUser ";
        $sql .= " FROM  user_chat_message " ;
		$sql .=" LEFT JOIN `user` ON user.UID = user_chat_message.FROM_ID ";
        $sql .= " WHERE user_chat_message.TO_ID = '$user_id' and  user_chat_message.Seen = 0 and user_chat_message.SentAt > date_sub(now(), interval 10 minute) order by user_chat_message.SentAt desc LIMIT 1" ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}	
	function get_message($session_id){
		$session_id = stripslashes($session_id);
        $session_id = mysql_real_escape_string($session_id);
		$dataset = array();
		$sql=" select user_chat_message.*, user.UserName as FromUser ";
        $sql .= " FROM  user_chat_message " ;
		$sql .=" LEFT JOIN `user` ON user.UID = user_chat_message.FROM_ID ";
        $sql .= " WHERE (user_chat_message.Session_Id = '$session_id') and (user_chat_message.SentAt >= DATE_SUB(NOW(), INTERVAL 1 DAY))   " ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}
	
	function get_my_conversations($uid){
		$uid = stripslashes($uid);
        $uid = mysql_real_escape_string($uid);
		$dataset = array();
		$sql=" select user_chat_message.*, user.UserName as FromUser ";
        $sql .= " FROM  user_chat_message " ;
		$sql .=" LEFT JOIN `user` ON user.UID = user_chat_message.FROM_ID ";
        $sql .= " WHERE ((user_chat_message.TO_ID = '$uid') OR (user_chat_message.FROM_ID = '$uid')) and (user_chat_message.message<>'Closed the chat session') " ;
		//$sql .="  group by user_chat_message.Session_Id ";
		$sql .=" order by  user_chat_message.SentAt desc limit 1,30";
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset; 	
	}
	
	function chat_close($chat_session,$to){
		if (!isset($chat_session)) return FALSE;
		if (!isset($to)) return FALSE;
		$data =array('Status'=>"CLOSE",'ClosedAt'=>date("Y-m-d H:i:s"));
		$this->db->where("Session_Id", $chat_session);
		$this->db->update("user_chat_session", $data); 
		
		$data =array('Seen'=>1);
		$this->db->where("Session_Id", $chat_session);
		$this->db->where("TO_ID", $to);
		$this->db->update("user_chat_message", $data); 
		
		return true;
	}
	function message_seen($msg_id){
		if (!isset($msg_id)) return FALSE;
		$data =array('Seen'=>1);
		$this->db->where("CHAT_MESSAGE_ID", $msg_id);
		$this->db->update("user_chat_message", $data); 
	}
	function change_status_to($uid,$sts){
		if (!isset($uid)) return FALSE;
		if (!isset($sts)) return FALSE;
		$data =array('Status'=>$sts);
		$this->db->where("UID", $uid);
		$this->db->update("user", $data); 
		return true;
	}
	function session_status($sess){
		$data = array();
		$sql=" SELECT Status  ";
			$sql .= " FROM user_chat_session WHERE user_chat_session.Session_Id = '".$sess."' " ;
			$Q =  $this->db->query($sql);
			if ($Q->num_rows() > 0){
				$data = $Q->row_array();
			}
		 $Q->free_result();    
        return $data;   	
	}
	function check_chat_session($user1,$user2){
		$data = array();
		$sql=" SELECT *  ";
        $sql .= " FROM user_chat_session WHERE   " ;
		$sql .= "  (((user_chat_session.USER1_ID = '".$user1."')AND(user_chat_session.USER2_ID = '".$user2."') ) OR((user_chat_session.USER1_ID = '".$user2."')AND(user_chat_session.USER2_ID = '".$user1."') ) )" ;
        $sql .= " and (user_chat_session.Status = 'OPEN') " ;
		
        $Q =  $this->db->query($sql);
        //echo "<br />".$this->db->last_query();
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();    
        return $data;   
	}
	
	function get_chat_user($chat_session,$me){
        $data = array();
        $data1 = array();
		$chat_session = stripslashes($chat_session);
		$me = stripslashes($me);

		$sql = " SELECT USER1_ID,USER2_ID ";
        $sql .= " FROM user_chat_session WHERE (Session_Id='$chat_session') AND ((USER2_ID='$me')OR(USER1_ID='$me')) and Status='OPEN' " ;
		
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();  
		if (!isset($data["USER1_ID"])){
			return false;
		}
		if (!isset($data["USER2_ID"])){
			return false;
		}
		if ($data["USER1_ID"]==$me){
			$sql=" SELECT FirstName,OtherName,UserGroup,Post,UID  ";
			$sql .= " FROM user WHERE UID = '".$data["USER2_ID"]."' " ;
			$Q =  $this->db->query($sql);
			if ($Q->num_rows() > 0){
				$data1 = $Q->row_array();
			}
		}
		else{
			$sql=" SELECT FirstName,OtherName,UserGroup,Post,UID  ";
			$sql .= " FROM user WHERE UID = '".$data["USER1_ID"]."' " ;
			$Q =  $this->db->query($sql);
			if ($Q->num_rows() > 0){
				$data1 = $Q->row_array();
			}		
		}
		 $Q->free_result(); 
        return $data1;    	
	}	
	
	function create_chat_session($user1,$user2){
		if ($user1 == 0 ) return FALSE;
		if (!isset($user1)) return FALSE;
		if ($user2 == 0 ) return FALSE;
		if (!isset($user2)) return FALSE;
		$session_id = md5(date("Y-m-d H:i:s"));
		$data =array('USER1_ID'=>$user1,'USER2_ID'=>$user2,'Session_Id'=> $session_id,'CreatedAt'=>date("Y-m-d H:i:s"),'Status'=>"OPEN",'ClosedAt'=>null);
		$this->db->insert("user_chat_session", $data); 
		return $session_id;
	}	
	
	function insert_message($data){
		if (!$data) return FALSE;
		$this->db->insert("user_chat_message", $data); 
		return true;
	}

}
