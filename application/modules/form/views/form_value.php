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
	//echo print_r($form);
	$this->load->database();
	
	$query = $this->db->query("select * from ".$form["TABLE"]." where ".$form["OBJID"]." = ".$id);
	if ($query->num_rows() > 0)
	{
		$row = $query->row_array(); 
	}
	//echo print_r($row);
	echo '<script>';
	for ( $i=0; $i < count($form["FLD"]); ++$i ){
		if($form["FLD"][$i]['type'] == "boolean"){
			if ($row[$form["FLD"][$i]["id"]] == "1"){
				$bool_val = "Yes";
			}
			else{
				$bool_val = "No";
			}
			echo '$("#'.$form["FLD"][$i]["id"].'").val("'.$bool_val.'");';
		}
		else{
			echo '$("#'.$form["FLD"][$i]["id"].'").val("'.$row[$form["FLD"][$i]["id"]].'");';
		}
	}
	echo '$("#'.$form["OBJID"].'").val("'.$row[$form["OBJID"]].'");';
	
	echo "</script>";
?>

