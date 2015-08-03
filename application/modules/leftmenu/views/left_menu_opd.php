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
						  $menu .="<a href='".base_url()."index.php/patient/view/".$pid."' class='list-group-item'><span class='glyphicon glyphicon-user'></span>&nbsp;Patient overview</a>";
						if ($this->config->item('block_opd_after') >= $d_day){	
							 if (($opd_visits_info["referred_admission_id"] == 0) &&($opd_visits_info["is_refered"] == 0)){
								$menu .="<a href='".base_url()."index.php/opd/reffer_to_admission/".$opdid."' class='list-group-item '><span class='glyphicon glyphicon-export'></span>&nbsp;Refer to admission</a>";
							  }
							  
							  $menu .="<a href='".base_url()."index.php/form/create/patient_history/".$pid."/?CONTINUE=opd/view/".$opdid."' class='list-group-item'><span class='glyphicon glyphicon-header'></span>&nbsp;Add History</a>";
							  $menu .="<a href='".base_url()."index.php/form/create/patient_alergy/".$pid."/?CONTINUE=opd/view/".$opdid."' class='list-group-item'><span class='glyphicon glyphicon-bell'></span>&nbsp;Add Allergy</a>";
							  $menu .="<a href='".base_url()."index.php/form/create/patient_exam/".$pid."/?CONTINUE=opd/view/".$opdid."' class='list-group-item'><span class='glyphicon glyphicon-check'></span>&nbsp;Add Examination</a>";
							  
							  $menu .="<a href='".base_url()."index.php/laboratory/opd_order/".$opdid."/?CONTINUE=opd/view/".$opdid."' class='list-group-item'><span class='glyphicon glyphicon-tint'></span>&nbsp;New Order Lab</a>";
							  $menu .="<a href='".base_url()."index.php/opd/new_prescribe/".$opdid."/?CONTINUE=opd/view/".$opdid."' class='list-group-item'><span class='glyphicon glyphicon-list-alt'></span>&nbsp;New Prescription</a>";
							  $menu .="<a href='".base_url()."index.php/form/create/opd_treatment/".$opdid."/?CONTINUE=opd/view/".$opdid."' class='list-group-item'><span class='glyphicon glyphicon-list'></span>&nbsp;Treatments</a>";
							  $menu .="<a href='".base_url()."index.php/form/create/opd_injection/".$pid."/".$opdid."/?CONTINUE=opd/view/".$opdid."' class='list-group-item'><span class='glyphicon glyphicon-pushpin'></span>&nbsp;Order an Injection</a>";
							$menu .="<a href='".base_url()."index.php/form/create/opd_notes/".$opdid."/?CONTINUE=opd/view/".$opdid."' class='list-group-item'><span class='glyphicon glyphicon-leaf'></span>&nbsp;Nursing notes</a>";
						}
						$menu .="</div>";
						
						
				
$menu .="<div class='list-group'>";
						  $menu .="<a href='' class='list-group-item active'>";
							$menu .="Prints";
						  $menu .="</a>";				
// Print patient slip
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSlip/print/$pid"
) . "')\" href='#'>Print patient slip</a>";

// Print patient card
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientCard/print/$pid"
) . "')\" href='#'>Print patient card</a>";

// Print patient summery
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSummery/print/$pid"
) . "')\" href='#'>Print patient summary</a>";

// Print visit summery
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/patientSummery/print/$pid"
) . "')\" href='#'>Print visit summary</a>";

// Print OPD Prescription
//$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
//    "report/pdf/opdPrescription/print/$opdid"
//) . "')\" href='#'>Prescription</a>";

// Print OPD Labtests
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/opdLabtests/print/$opdid"
) . "')\" href='#'>Lab test</a>";

// Print clinic book
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/clinicBook/print/$opdid"
) . "')\" href='#'>Print Clinic Book</a>";

				$menu .="</div>";
				
				$menu .="<div class='list-group'>";
				  $menu .="<a href='' class='list-group-item active'>";
					$menu .="Generic Modules";
				  $menu .="</a>";
				$menu .="</div>";				
			
			$menu .=" </div> \n";
        echo $menu ;	  
?>