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
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>";
echo "\n<html xmlns='http://www.w3.org/1999/xhtml'>";
echo "\n<head>";
echo "\n<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
echo "\n<title>".$this->config->item('title')."</title>";
echo "\n<link rel='icon' type='". base_url()."image/ico' href='images/mds-icon.png'>";
echo "\n<link rel='shortcut icon' href='". base_url()."images/mds-icon.png'>";
echo "\n<link href='". base_url()."/css/mdstheme_navy.css' rel='stylesheet' type='text/css'>";
echo "\n<script type='text/javascript' src='". base_url()."js/jquery.js'></script>";
echo "\n    <script type='text/javascript' src='".base_url()."js/bootstrap/js/bootstrap.min.js' ></script>";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css' />";
echo "\n    <link href='". base_url()."js/bootstrap/css/bootstrap-theme.min.css' rel='stylesheet' type='text/css' />";  
echo "\n<script type='text/javascript' src='". base_url()."/js/mdsCore.js'></script> ";
echo "\n</head>";
	
?>
<?php echo Modules::run('menu'); //runs the available menu option to that usergroup ?>
<div class="container" style="width:95%;">
	<div class="row" style="margin-top:55px;">
	  <div class="col-md-2 ">
	  </div>
		<div class="col-md-4" >
		<div class="panel panel-default"  >
			<div class="panel-heading"><b>Appointment token</b>
			</div>
				<div style="padding:10px;">
				<?php
					echo "Patient : ".$patient_info["Personal_Title"].' '.$patient_info["Full_Name_Registered"].' ' .$patient_info["Personal_Used_Name"]."<br>";
					echo "Appointment date : ".$appointment_info["VDate"]."<br>";
					echo "Token type : ".$appointment_info["Type"]."<br>";
					echo "Doctor : ".$dr_info["Title"].' '.$dr_info["FirstName"].' '.$dr_info["OtherName"]. "<br>";
					echo "<b>TOKEN NO : ".$appointment_info["Token"]. "<hr>";
                    echo "<a class='btn btn-default' onclick=\"openWindow('" . site_url(
                    "report/pdf/appointment/print/".$this->uri->segment(3)
                ) . "')\" href='#'>Print token</a>";
				?>


<!--                    <button type="button" onclick="window.location=--><?php //echo site_url("report/pdf/patientSlip/print/".$this->uri->segment(3)); ?><!--" class="btn btn-primary">Print token</button>-->
					<a  class="btn btn-default" href="<?php echo site_url("patient/view/".$patient_info["PID"]); ?>">Patent overview</a>
				</div>
			</div>
		</div>
	</div>
</div>
