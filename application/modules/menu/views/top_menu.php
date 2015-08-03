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
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/

	$menuItems = "";
	for ($i=0; $i < count($user_menu); ++$i){
		 
		if ($user_menu[1] == "home") {
			$menuItems .=$this->session->userdata('mid').'1<a role="main_menu" id="'.$user_menu[$i]["UMID"].'" class="btn ';
			if ($this->session->userdata('mid') == $user_menu[$i]["UMID"]){
					$menuItems .= ' btn-warning';
				}
				else{
					$menuItems .= ' btn-info';
				}
			$menuItems .=' btn-xs" href="#">'.$user_menu[$i]["Name"].'</a>';
		 }
		 elseif ($user_menu[$i]["Name"] == "Log Out") {
			$menuItems .='<a  class="btn btn-danger btn-xs"  href="'.base_url().'index.php/'.$user_menu[$i]["Link"].'/?mid='.$user_menu[$i]["UMID"].'">';
				$menuItems .=$user_menu[$i]["Name"];
				$menuItems .='</a>';
		 }
		 else {
		 		$menuItems .='<a role="main_menu"  id="'.$user_menu[$i]["UMID"].'"   class="btn ';
				if ($this->session->userdata('mid') == $user_menu[$i]["UMID"]){
					$menuItems .= ' btn-warning';
				}
				else{
					$menuItems .= ' btn-info';
				}
				$menuItems .=' btn-xs"  href="'.base_url().'index.php/'.$user_menu[$i]["Link"].'/?mid='.$user_menu[$i]["UMID"].'">';
				$menuItems .=$user_menu[$i]["Name"];
				$menuItems .='</a>';
		 }
	}
	//print_r($this->session);
	if ($this->session->flashdata('msg')){
		echo '<div class="row">';
			echo '<div class="col-lg-4">';
			echo '</div>';
			echo '<div class="col-lg-4">';
			echo '</div>';
			echo '<div class="col-lg-4">';
				echo '<div class="alert alert-warning alert-dismissable" id="top_message" style="position:absolute;z-index:999999;">';
				  echo '<button type="button" class="close" data-dismiss="alert">×</button>';
				  echo $this->session->flashdata('msg');
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	
?>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation" style="height:50px;">
      <div>
        <div class="navbar-header">
          <a href="<?php echo base_url(); ?>index.php" style="font-size:30px;padding-left:5px;padding-right:5px;" tittle="<?php echo $this->config->item('app_name'); ?>">
		  <img src="<?php echo base_url(); ?>images/hhims.png" height=50 />
		  </a>
        </div>
		<div style='margin-left:80px;padding-bottom:2px;'>
			<ol class="breadcrumb" style="padding:0px;margin:0px">
				<li class="active">Date: <?php echo  date("Y-m-d"); ?></li>
			<?php 	if ($this->config->item('purpose') =="PP"){
						echo "<li class=\"active\">Private Practice /  </li><?php ";
					}else{
						echo "<li class=\"active\">Hospital:".$this->session->userdata('Hospital')."</li>";
					}
				?>
				<li class="active"><?php echo " ".$this->session->userdata('FullName'); ?></li>
				<li class="active">
					<?php 
					
					if ($this->session->userdata('UserGroup')   == "Programmer"){
							 echo '<span class="label label-danger">'.$this->session->userdata('UserGroup').'</span>';  						
						}else{
							echo $this->session->userdata('UserGroup') ; 
						}
					
					?>
				</li>	
			</ol>
		</div>
        <div class="navbar-collapse collapse" >
          <ul class="nav navbar-nav nav-pills" >
         
             <?php echo $menuItems; ?>
          </ul>
          <span class="nav navbar-nav navbar-right" style="padding-right:15px;">
          
<!-- PP configuration, Start production button in config mode -->

		<?php 
	//if ($this->config->item('purpose') == "PP"&& $this->session->userdata('UserGroup')== "Admin"){
		if ($this->session->UserData("Config") == 'config_admin'){
		 ?>
		<button type="button" class="btn btn-danger btn-xs" onclick='if(window.confirm("Are you ready to start production? \n Deletion will not be allowed anymore")){ window.location.href = "/hhims/index.php/user/start_production"} ' > Start Production </button>
         <?php 	
		}else if ($this->session->UserData("Config") == 'config_other'){ 
         	echo "<script> alert('Contact your administrator to start production!');
         	document.location = '".base_url()."index.php/login'; </script> ";
         	
         	 }?>
         
<!--  -->
      
			<button type="button" class="btn btn-default btn-sm" onclick=open_location('<?php echo site_url("help/about") ?>')>
				<span class="glyphicon glyphicon-info-sign"></span>
			</button>	
			<button type="button" class="btn btn-default btn-sm" onclick=open_location('<?php echo base_url(); ?>help')>
				<span class="glyphicon glyphicon-question-sign"></span>
			</button>	
			<!--<button type="button" class="btn btn-default btn-sm">
				<span class="glyphicon glyphicon-envelope"></span>
			</button>	
			
			<button type="button" class="btn btn-default btn-sm">
				<span class="glyphicon glyphicon-refresh"></span>
			</button>	
			-->
			<button type="button" id="my_status" class="btn btn-default btn-sm btn-success dropdown-toggle" data-toggle="dropdown" onclick="load_chat_list();">
			  <span class="glyphicon glyphicon-user" ></span>
			</button>
			<ul class="dropdown-menu" id="chat_list">
			</ul>
          </span>
        </div>
      </div>
    </div>
	<div id="btn_cont" style=" position: fixed; bottom: 0; right: 0;z-index:999999;"></div>
<script language='javascript'>
	var chat_timer = null;
	var chat_win = null;
	setInterval("$('#top_message').fadeOut('slow')",<?php echo $this->config->item('flash_time')*1000; ?>);
	 function load_chat(uid){
		if ( uid > 0 ){
			var request = $.ajax({
				url: "<?php echo base_url(); ?>index.php/chat/load_chat/"+uid,
				type: "post"
			});
			request.done(function (response, textStatus, jqXHR){
				chat_win = window.open("<?php echo base_url(); ?>index.php/chat/load/"+response,"chat"+response,"width=500,height=520,top=100,left=300,toolbar=no,scrollbars=no,location=no,resizable =no")	
				chat_win.focus();
			});
			
		}
	 }
	 function change_status_to(sts){
		var request = $.ajax({
			url: "<?php echo base_url(); ?>index.php/chat/change_status_to/"+sts,
			type: "post"
		});
		request.done(function (response, textStatus, jqXHR){
			if (sts == "OFF_LINE"){
				$("#my_status").removeClass("btn-success").addClass("btn-danger");
			}
			else{
				$("#my_status").removeClass("btn-danger").addClass("btn-success");
			}
		});
	 }
	 function load_chat_list(){
		var request = $.ajax({
			url: "<?php echo base_url(); ?>index.php/chat/get_chat_list",
			type: "post"
		});
		request.done(function (response, textStatus, jqXHR){
			$("#chat_list").html(response);
		});
	 }
	 function make_seen(msg_id){
		var request = $.ajax({
			url: "<?php echo base_url(); ?>index.php/chat/message_seen/"+msg_id,
			type: "post"
		});
	 }
	 function reply(user,msg_id){
		make_seen(parseInt(msg_id));
		load_chat(parseInt(user));
		$(".alert").alert('close')
	 }
	 (function check_message(){
		if (chat_win) return;
		$.each($('audio'), function () {
			this.stop();
		});
		var request = $.ajax({
			url: "<?php echo base_url(); ?>index.php/chat/check_message/<?php  echo $this->session->userdata('UID'); ?>",
			type: "post"
		});

		request.done(function (response, textStatus, jqXHR){
				var msg = eval('(' + response + ')');
				if ((msg) && (msg.length==1)){
					text_msg ='<div class="alert alert-info  alert-dismissable" style="max-width:200px;">';
					
					text_msg +='<button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick=make_seen("'+msg[0].CHAT_MESSAGE_ID+'") >&times;</button>';
					text_msg +='<b>'+msg[0].FromUser+' Says : </b>'+msg[0].Message;
					text_msg +='<BR><button class="btn btn-success btn-xs" onclick="reply(\''+msg[0].FROM_ID+'\',\''+msg[0].CHAT_MESSAGE_ID+'\')">Reply</button>';
					text_msg +='<audio src="<?php echo base_url(); ?>/js/chat/audio/message.mp3" preload="auto" autoplay ></audio>';
					text_msg +='</div>';
					$("#btn_cont").html(text_msg);
				}
		});
		$.each($('audio'), function () {
			this.stop();
		});
		chat_timer = setTimeout(check_message, 5000); 
	 }());
	
	$(document).ready(function () {
		var color = "<?php echo $this->config->item($this->uri->segment(1).'_bck_color'); ?>";
		if (color){
			$("body").css({"background-color":color})
		}
		$("a[role='main_menu']").click(function(){
			$("a[role='main_menu']").removeClass("btn-warning");
			$(this).addClass("btn-warning");
		});
	});
	
	//For HOt key
	
	$(document).ready(function(){
		//jQuery(document).bind('keydown', 'Ctrl+f',function (evt){evt.preventDefault( ); getSearchText('patient'); return true;});
		jQuery(document).bind('keydown', 'Alt+f',function (evt){evt.preventDefault( ); getSearchText('patient'); return false;});
		
		/*
		$('INPUT[value=Home]').focus();
		char0 = new Array("§", "32");
		char1 = new Array("˜", "732");
		characters = new Array(char0, char1);
		*/
		//$(document).BarcodeListener(characters, function(code) {
		//});
	});
	function getSearchText(tpe) {
	var pid = prompt("Patient ID?");
	if (pid>0){
		self.document.location="<?php echo base_url(); ?>index.php/patient/view/"+pid;
	}
}
	 /*
	idleMax = parseInt("<?php echo $this->config->item('auto_logout_time'); ?>");// Logout after t minutes of IDLE
	idleTime = 0;
	$(document).ready(function () {
		var idleInterval = setInterval("timerIncrement()", 1000); 
		$(this).mousemove(function (e) {idleTime = 0;});
		$(this).keypress(function (e) {idleTime = 0;});
	})
	function timerIncrement() {
		idleTime = idleTime + 1;
		if (idleTime > idleMax) { 
			window.location="<?php echo base_url(); ?>index.php/login/logout";
		}
	}
	*/
</script>
