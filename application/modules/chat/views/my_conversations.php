<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
	echo Modules::run('menu'); //runs the available menu option to that usergroup
?>
<div  style="width:95%;">
	<div class="row" style="margin-top:55px;">
	  <div class="col-md-2 ">
		<?php echo Modules::run('leftmenu/chat'); //runs the available left menu for preferance ?>
	  </div>
	  <div class="col-md-10 ">
			<div class="panel panel-default"  >
				<div class="panel-heading"><b>My chat conversations</b></div>
				<?php 
					if(isset($my_conversations)&& count($my_conversations)>0){
						echo '<table class="table table-striped table-condensed table-bordered table-hover">';
							for ($i=0; $i<count($my_conversations);++$i){
								echo '<tr>';
									echo '<td>';
									if ($this->session->userdata("UserName") == $my_conversations[$i]["FromUser"]){
										echo '<span class="pull-left"  style="width:100px;">Me</span>';
									}
									else{
									echo '<span class="pull-left" style="width:100px;">'.$my_conversations[$i]["FromUser"].'</span>';
									}
									echo '&nbsp;&nbsp;&nbsp;&nbsp;';
									echo '<span class="pull-center">'.$my_conversations[$i]["Message"].'</span>';
									echo '<span class="pull-right">'.date_format(date_create($my_conversations[$i]["SentAt"]),"M d g:i a").'</span>';
									echo '</td>';
								echo '</tr>';
							}							
						echo '</table>';
					}
				?>
			</div>
		</div>
	</div>
</div>