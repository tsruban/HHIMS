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

if ($this->config->item('purpose') !="PC"){ // Create a visit for GH and PP
	$menu .="<a href='".base_url()."index.php/form/create/opd_visits/".$id."' class='list-group-item'><span class='glyphicon glyphicon-eye-open'></span>&nbsp;Create a Visit</a>";

	if ($this->config->item('purpose') !="PP"){ // Create an admission for GH only
		$menu .="<a href='".base_url()."index.php/form/create/admission/".$id."' class='list-group-item'><span class='glyphicon glyphicon-inbox'></span>&nbsp;Give an Admission</a>"; // not for PP & PC
	}
}

if ($this->config->item('purpose') !="PP"){ // Clinic management for GH and PC
	$menu .="<a href='".base_url()."index.php/patient/clinic/".$id."' class='list-group-item '><span class='glyphicon glyphicon-export'></span>&nbsp;Clinic management*</a>"; // not for PP
}

if ($this->config->item('purpose') !="PC"){ // Appointement for GH and PP
	$menu .="<a href='".base_url()."index.php/form/create/appointment/".$id."/?CONTINUE=patient/view/".$id."' class='list-group-item'><span class='glyphicon glyphicon-time'></span>&nbsp;Give an appointment</a>"; //not for PC
}
//history, allergy, exam and attachement for All
$menu .="<a href='".base_url()."index.php/form/create/patient_history/".$id."/?CONTINUE=patient/view/".$id."' class='list-group-item'><span class='glyphicon glyphicon-header'></span>&nbsp;Add History</a>";
$menu .="<a href='".base_url()."index.php/form/create/patient_alergy/".$id."/?CONTINUE=patient/view/".$id."' class='list-group-item'><span class='glyphicon glyphicon-bell'></span>&nbsp;Add Allergy</a>";
$menu .="<a href='".base_url()."index.php/form/create/patient_exam/".$id."/?CONTINUE=patient/view/".$id."' class='list-group-item'><span class='glyphicon glyphicon-check'></span>&nbsp;Add Examination</a>";
$menu .="<a href='".base_url()."index.php/form/create/attachment/".$id."/?CONTINUE=patient/view/".$id."' class='list-group-item'><span class='glyphicon glyphicon-paperclip'></span>&nbsp;Attach File</a>";

if ($this->config->item('purpose') !="PC"){ // Nursing notes for GH and PP
	$menu .="<a href='".base_url()."index.php/form/create/patient_notes/".$id."/?CONTINUE=patient/view/".$id."' class='list-group-item'><span class='glyphicon glyphicon-leaf'></span>&nbsp;Nursing notes</a>"; // not for PC
}

$menu .="</div>";
$menu .="<div class='list-group'>";
$menu .="<a href='' class='list-group-item active'>";

$menu .="Prints";
$menu .="</a>";
// Print patient slip
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSlip/print/$id"
) . "')\" href='#'>Print patient slip</a>";

// Print patient card
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientCard/print/$id"
) . "')\" href='#'>Print patient card</a>";

// Print patient summery
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSummery/print/$id"
) . "')\" href='#'>Print patient summary</a>";
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "patient/notes/$id"
) . "')\" href='#'>Print nursing notes</a>";
				$menu .="</div>";	
				if ($this->config->item('purpose') !="PC"){ // Questionnaires for GH and PP
						$menu .="<div class='list-group'>";
						$menu .="<a href='' class='list-group-item active'>";
						$menu .="Generic Modules";
						$menu .="</a>";
						if (isset($module)&&count($module)>0){
							for($i=0; $i<count($module); ++$i){
								$menu .=" <a ";
								$menu .=" href='".base_url()."index.php/questionnaire/load/".$module[$i]["qu_questionnaire_id"]."/".$id."/patient/".$id."?CONTINUE=patient/view/".$id."' ";
								$menu .=" title='".$module[$i]["description"]."' ";
								$menu .=" class='list-group-item'><span class='glyphicon glyphicon-list'></span>&nbsp;".$module[$i]["name"];
								$menu .=" </a>";
							}	
					  	}
						$menu .="</div>";				
				}
			$menu .=" </div> \n";
        echo $menu ;	  
?>