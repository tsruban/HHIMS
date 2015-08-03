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

	include("header.php");	///loads the html HEAD section (JS,CSS)
?>
<?php echo Modules::run('menu'); //runs the available menu option to that usergroup ?>
<div class="container" style="width:95%;">
	<div class="row" style="margin-top:55px;">
	  <div class="col-md-2 ">
		<?php echo Modules::run('leftmenu/user'); //runs the available left menu for preferance ?>
	  </div>
	  <div class="col-md-10 ">
	  <?php
		echo '<div class="panel panel-default"  style="padding:2px;margin-bottom:1px;" >';
			echo '<div class="panel-heading" ><b>My Profile / settings</b></div>';
				echo '<table class="table table-condensed table-hover"  style="font-size:0.95em;margin-bottom:0px;cursor:pointer;">';
					echo '<tr >';
						echo '<td width=20%>';
							echo 'Full name: ';
						echo '</td>';
						echo '<td>';
							echo $user_info["Title"].' '.$user_info["FirstName"].' '.$user_info["OtherName"];
						echo '</td>';
					echo '</tr>';					
					echo '<tr >';
						echo '<td width=20%>';
							echo 'Date of birth: ';
						echo '</td>';
						echo '<td>';
							echo $user_info["DateOfBirth"];
						echo '</td>';
					echo '</tr>';
						echo '<td width=20%>';
							echo 'Gender**: ';
						echo '</td>';
						echo '<td>';
							echo $user_info["Gender"];
						echo '</td>';
					echo '</tr>';
						echo '<td width=20%>';
							echo 'Civil status: ';
						echo '</td>';
						echo '<td>';
							echo $user_info["CivilStatus"];
						echo '</td>';
					echo '</tr>';					
					echo '<tr >';
						echo '<td width=20%>';
							echo 'User Group: ';
						echo '</td>';
						echo '<td>';
							echo $user_info["UserGroup"];
						echo '</td>';
					echo '</tr>';					
					echo '<tr >';
						echo '<td width=20%>';
							echo 'User Name: ';
						echo '</td>';
						echo '<td>';
							echo $user_info["UserName"];
						echo '</td>';
					echo '</tr>';

				echo '</table>';
		echo '</div>';
?>		
	  </div>
	</div>
	
</div>
