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
           $menu .="<div id='left-sidebar1' style='position:fixed1;'>\n";
				$menu .="<div class='list-group'>";
				  $menu .="<a href='' class='list-group-item active'>";
					$menu .="Commands";
				  $menu .="</a>";
				  $menu .="<a href='".base_url()."index.php/patient/view/".$pid."' class='list-group-item'><span class='glyphicon glyphicon-user'></span>&nbsp;Patient overview</a>";
				  $menu .="<a href='".base_url()."index.php/clinic/new_visit/".$clinic_patient_info["clinic_patient_id"]."/?CONTINUE=clinic/open/".$clinic_patient_info["clinic_patient_id"]."' class='list-group-item'><span class='glyphicon glyphicon-eye-open'></span>&nbsp;Create a clinic visit</a>";
				  //$menu .="<a href='".base_url()."index.php/form/create/patient_history/".$pid."/?CONTINUE=clinic/open/".$clinic_patient_info["clinic_patient_id"]."' class='list-group-item'><span class='glyphicon glyphicon-header'></span>&nbsp;Add History</a>";
				  //$menu .="<a href='".base_url()."index.php/form/create/patient_alergy/".$pid."/?CONTINUE=clinic/open/".$clinic_patient_info["clinic_patient_id"]."' class='list-group-item'><span class='glyphicon glyphicon-bell'></span>&nbsp;Add Allergy</a>";
				  $menu .="<a href='".base_url()."index.php/form/create/patient_exam/".$pid."/?CONTINUE=clinic/open/".$clinic_patient_info["clinic_patient_id"]."' class='list-group-item'><span class='glyphicon glyphicon-check'></span>&nbsp;Add Examination</a>";

				  $menu .="<a href='".base_url()."index.php/clinic/new_prescribe/".$clinic_patient_info["clinic_patient_id"]."/CLN/?CONTINUE=clinic/open/".$clinic_patient_info["clinic_patient_id"]."' class='list-group-item'><span class='glyphicon glyphicon-list-alt'></span>&nbsp;New Prescription</a>";
  				  $menu .="<a href='".base_url()."index.php/laboratory/clinic_order/".$clinic_patient_info["clinic_patient_id"]."/?CONTINUE=clinic/open/".$clinic_patient_info["clinic_patient_id"]."' class='list-group-item'><span class='glyphicon glyphicon-tint'></span>&nbsp;New Order Lab</a>";

				$menu .="</div>";
				
				/*
				$menu .="<div class='list-group'>";
				  $menu .="<a href='' class='list-group-item active'>";
					$menu .="Generic Modules";
				  $menu .="</a>";
				  if (isset($module)&&count($module)>0){
					for($i=0; $i<count($module); ++$i){
						$menu .=" <a ";
						$menu .=" href='".base_url()."index.php/questionnaire/load/".$module[$i]["qu_questionnaire_id"]."/".$pid."/clinic_patient/".$clinic_patient_info["clinic_patient_id"]."?CONTINUE=clinic/open/".$clinic_patient_info["clinic_patient_id"]."/".$pid."' ";
						$menu .=" title='".$module[$i]["description"]."' ";
						$menu .=" class='list-group-item'><span class='glyphicon glyphicon-list'></span>&nbsp;".$module[$i]["name"];
						$menu .=" </a>";
					}	
				  }				  
				$menu .="</div>";				
				*/
				$menu .="<div class='list-group'>";
				  $menu .="<a href='' class='list-group-item active'>";
					$menu .="Prints";
				  $menu .="</a>";
// Print patient slip
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSlip/print/$pid"
) . "')\" href='#'>Print patient slip</a>";

// Print patient card
/*
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientCard/print/$pid"
) . "')\" href='#'>Print patient card</a>";

// Print patient summery
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSummery/print/$pid"
) . "')\" href='#'>Print patient summery</a>";
*/
				$menu .="</div>";

				
			$menu .=" </div> \n";
        echo $menu ;	  
?>