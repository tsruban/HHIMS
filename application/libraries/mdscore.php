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

class Mdscore {
	public function loadHeader($head) {
		$out = "<img class='pageHelp' src='images/help.png' width=30 height=30 valign=middle>\n";
		echo "<div id='mdsHead' class='mdshead'>" . getPrompt($head) . "</div>\n";
	}
	public function print_debug($data){
		echo '<div class="alert alert-danger" style="margin-top:55px;">';
		echo print_r($data);
		echo '</div>';
		
	}
	public function js($cmd) {
		echo "<script language=javascript>";
		echo $cmd;
		echo "</script>";
	}

	public function getMDSDate($dte_arr) {
		return $dte_arr[year] . "-" . $dte_arr[month] . "-" . $dte_arr[day];
	}


	public function getLoggedUser() {
		return $_SESSION["FirstName"] . " " . $_SESSION["OtherName"];
	}

	public function getHospital() {
		return $_SESSION["Hospital"];
	}

	public function mdsError($err) {
		$text = "<div class='mdsAccessError'>" . $err . "<br><a href='javascript:window.history.back()'>Return</a></div>";
		return $text;
	}
	public function diplayMessage($text,$head,$w,$h){
		$js = '';
			$js .='<script language="javascript"> ';
			$js .='$(\'<div id="mds_msg" title="'.$head.'"></div>\').appendTo("body");';
		$js .='$("#mds_msg").html("Getting information...");';
	   
		$js .='$("#mds_msg").html("'.$text.'");';
		$js .='$("#mds_msg").dialog({';
			$js .=' width:'.$w.',';
			$js .=' height:'.$h.',';
			$js .=' autoOpen:true,';
			$js .=' modal: true,';
			$js .=' resizable:false,';
			$js .=' position:"center",';
			$js .=' close: function(event, ui){ ';
				$js .= 'history.back()';
			$js .=' }';
		$js .=' });';   
		$js .=' </script>';
		return $js;
	}
	public function sanitize($data){
			$data=trim($data);
			$data=htmlspecialchars($data);
			$data = mysql_escape_string($data);
			$data = stripslashes($data);
			return $data;
	}

	public function getDiffDays($startDate, $endDate) {

		$startDate = strtotime($startDate);
		$endDate = strtotime($endDate);
		return intval(abs(($startDate - $endDate) / 86400));
		
	}
}
?>