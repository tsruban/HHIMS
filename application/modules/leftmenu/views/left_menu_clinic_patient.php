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
				$menu .="Reports";
			  $menu .="</a>";
//			  $menu .="<a href='".base_url()."index.php/laboratory' class='list-group-item'>OPD Lab Orders</a>";
	//		  $menu .="<a href='".base_url()."index.php/laboratory' class='list-group-item'>Admission Lab Orders</a>";
		//	  $menu .="<a href='".base_url()."index.php/laboratory' class='list-group-item'>Collection Room</a>";
			$menu .="</div>";
			
			$menu .=" </div> \n";
        echo $menu ;
?>