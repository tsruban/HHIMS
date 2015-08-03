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
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
//print_r($user_menu);
// $mdsPermission = MDSPermission::GetInstance();
$menu = "";
$menu .= "<div id='left-sidebar1' style='position:fixed1;'>\n";
$menu .= "<div class='list-group'>";
$menu .= "<a href='' class='list-group-item active'>";
$menu .= "Patient";
$menu .= "</a>";

// encounter statistics
$menu .= "<a class='list-group-item' data-toggle=\"modal\" href=\"" . site_url(
    "report/pdf/encounters/view"
) . "\" data-target=\"#encounter-stats\">Encounter Statistics</a>";

// visit details
$menu .= "<a class='list-group-item' data-toggle=\"modal\" href=\"" . site_url(
    "report/pdf/visitDetails/view"
) . "\" data-target=\"#visit-details\">Visit Details</a>";

// visit complaint treated
$menu .= "<a class='list-group-item' data-toggle=\"modal\" href=\"" . site_url(
    "report/pdf/visitComplaints/view"
) . "\" data-target=\"#visit-complaints\">Visit Complaint Treated</a>";

$menu .= "</div>";

$menu .= "<div class='list-group'>";
$menu .= "<a href='' class='list-group-item active'>";
if ($this->config->item('purpose') !="PP"){
	$menu .= "Hospital";
}else{
	$menu .= "Private practice";
}
$menu .= "</a>";
// current stock balance
$menu .= "<a class='list-group-item' onclick=\"openWindow('" . site_url(
    "report/pdf/pharmacyCurrentStock/print"
) . "')\" href='#'>Current stock balance</a>";
//create drug order
$menu .= "<a class='list-group-item' data-toggle=\"modal\" href=\"" . site_url(
    "report/pdf/drugOrder/view"
) . "\" data-target=\"#order\">Create drug order</a>";
// daily drugs dispensed
$menu .= "<a class='list-group-item' data-toggle=\"modal\" href=\"" . site_url(
    "report/pdf/pharmacyBalance/view"
) . "\" data-target=\"#daily\">Daily drugs dispensed</a>";
// immr
if ($this->config->item('purpose') !="PP"){
	$menu .= "<a class='list-group-item' data-toggle=\"modal\" href=\"" . site_url(
	    "report/pdf/immr/view"
	) . "\" data-target=\"#immr\">Hospital IMMR</a>";
	
	// immr
	$menu .= "<a class='list-group-item' data-toggle=\"modal\" href=\"" . site_url(
	    "report/pdf/hospitalPerformance/view"
	) . "\" data-target=\"#performance\">Hospital performance</a>";
}
$menu .= "</div>";

$menu .= " </div> \n";
echo $menu;
?>