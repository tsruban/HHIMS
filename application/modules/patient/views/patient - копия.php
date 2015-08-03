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

	include_once("header.php");	///loads the html HEAD section (JS,CSS)
	echo '<table border=0 width=100% cellspacing=0 cellpading=0>';
		echo '<tr>';
			echo '<td colspan=2 id="top_menu">';
					echo '<div id="header">';
						echo Modules::run('menu'); //runs the available menu option to that usergroup
					echo '</div>';
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td colspan=2	>';
				echo '<div class="mdshead">';
				echo 'Patient registration / New';
				echo Modules::run('hhims/get_user_info'); //gets the user information from SESSION
				echo '</div>';
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td  id="left_menu" width=200px valign="top">';
			echo '</td>';
			echo '<td  id="content"  valign="top">';
				echo Modules::run('form/create','patient');
			echo '</td>';
		echo '</tr>';
	echo '<table>';
?>
