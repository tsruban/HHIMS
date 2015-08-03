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
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//print_r($user_menu);
      // $mdsPermission = MDSPermission::GetInstance();
           $menu = "";
           $menu .="<div id='left-sidebar1' style='position:fixed;'>\n";
				$menu .="<div class='list-group'>";
				  $menu .="<a href='' class='list-group-item active'>";
					$menu .="Commands";
				  $menu .="</a>";
				 if (isset($admission["OutCome"])&&($admission["OutCome"])){
					if (isset($_GET["BACK"])){
					 $menu .="<a href='".site_url($_GET["BACK"])."' class='list-group-item'><span class='glyphicon glyphicon-circle-arrow-left'></span>&nbsp;Back to ward</a>";
					}
				  $menu .="<a href='".base_url()."index.php/patient/view/".$pid."' class='list-group-item'><span class='glyphicon glyphicon-user'></span>&nbsp;Patient overview</a>";
				 }
				 else{
					if (isset($_GET["BACK"])){
					 $menu .="<a href='".site_url($_GET["BACK"])."' class='list-group-item'><span class='glyphicon glyphicon-circle-arrow-left'></span>&nbsp;Back to ward</a>";
					}
					$menu .="<a href='".base_url()."index.php/patient/view/".$pid."' class='list-group-item'><span class='glyphicon glyphicon-user'></span>&nbsp;Patient overview</a>";
					 $menu .="<a href='".base_url()."index.php/form/create/patient_history/".$pid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-header'></span>&nbsp;Add History</a>";
					  $menu .="<a href='".base_url()."index.php/form/create/patient_alergy/".$pid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-bell'></span>&nbsp;Add Allergy</a>";
					  $menu .="<a href='".base_url()."index.php/form/create/patient_exam/".$pid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-check'></span>&nbsp;Add Examination</a>";
					  
					  //$menu .="<a href='".base_url()."index.php/' class='list-group-item'><span class='glyphicon glyphicon-question-sign'></span>&nbsp;Diagnosis</a>";
					 $menu .="<a href='".base_url()."index.php/laboratory/admission_order/".$admid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-tint'></span>&nbsp;New Order Lab</a>";
					 $menu .="<a href='".base_url()."index.php/form/create/admission_diagnosis/".$admid."/".$pid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-question-sign'></span>&nbsp;Diagnosis</a>";
					  if (isset($order_id)&&($order_id>0)){
						$menu .="<a href='".base_url()."index.php/admission/prescription/".$order_id."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-list-alt'></span>&nbsp;Order Drug</a>";
						$menu .="<a href='".base_url()."index.php/admission/drug_chart/".$order_id."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-indent-left'></span>&nbsp;Nursing drug chart</a>";
					  }
					  else{
						$menu .="<a href='".base_url()."index.php/admission/new_prescribe/".$admid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-list-alt'></span>&nbsp;Order Drug</a>";
					  }
					 // $menu .="<a href='".base_url()."index.php/form/create/admission_treatment/".$admid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-list'></span>&nbsp;Procedures</a>";
						$menu .="<a href='".base_url()."index.php/form/create/admission_notes/".$admid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-leaf'></span>&nbsp;Nursing notes</a>";
					  $menu .="<a href='".base_url()."index.php/form/create/admission_transfer/".$admid."/".urlencode($admission["Ward"])."?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-transfer'></span>&nbsp;Ward Transfer</a>";
					  $menu .="<a href='".base_url()."index.php/form/edit/admission_discharge/".$admid."/?CONTINUE=admission/view/".$admid."' class='list-group-item'><span class='glyphicon glyphicon-folder-close'></span>&nbsp;Discharge</a>";
				}	
					$menu .="</div>";
				
				$menu .="<div class='list-group'>";
				  $menu .="<a href='' class='list-group-item active'>";
					$menu .="Prints";
				  $menu .="</a>";
// Print patient BHT
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/admissionBHT/print/$admid"
) . "')\" href='#'>BHT</a>";

// Print patient Transfer letter
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/admissionTransfer/print/$admid"
) . "')\" href='#'>Transfer letter</a>";

// Print admission summary
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
        "report/pdf/admissionSummary/print/$admid"
    ) . "')\" href='#'>Admission Summary</a>";

// Print patient discharge ticket
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/admissionDischarge/print/$admid"
) . "')\" href='#'>Discharge ticket</a>";

// Print patient summery
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSummery/print/$pid"
) . "')\" href='#'>Print patient summery</a>";

// Print patient slip
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSlip/print/$pid"
) . "')\" href='#'>Print patient slip</a>";

// Print patient card
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientCard/print/$pid"
) . "')\" href='#'>Print patient card</a>";
				$menu .="</div>";	
				
				$menu .="<div class='list-group'>";
				  $menu .="<a href='' class='list-group-item active'>";
					$menu .="Generic Modules";
				  $menu .="</a>";
				$menu .="</div>";				
			
			$menu .=" </div> \n";
        echo $menu ;	  
?>