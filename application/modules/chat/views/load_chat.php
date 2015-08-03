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
?>
<body>
<div>
  <div class="col-md-10 ">
		<div class="panel panel-default"  >
			<div class="panel-heading">
			<?php 
			if (!$chat_user){
				echo '<b>Unknown Session</b>';
				exit;
			}
			?>
			<b><?php echo $chat_user["FirstName"]; ?> - Chat</b>
			
			<button type="button" class="btn btn-danger  btn-xs pull-right" id="close_button">Close</button>
			
			</div>
			<div id="chat_content" class="well" style="height:380px;margin-bottom:0px; overflow-y: scroll;">
			<?php
				//echo print_r($chat_user);
				//echo print_r($this->session);
			?>
			</div>
			<div class="btn-toolbar">
				<div class="btn-group">
				  <button type="button" class="btn btn-default" id="share_button"><span class="glyphicon glyphicon-share" title="Share my screen"></span></button>
				  <!--<button type="button" class="btn btn-default" id="attention_button"><span class="glyphicon glyphicon-bell" title="Attention"></span></button>
				  <button type="button" class="btn btn-default" id="blood_button"><span class="glyphicon glyphicon-tint" title="Blood"></span></button>
				  <button type="button" class="btn btn-default" id="alert_button"><span class="glyphicon glyphicon-volume-up" title="Alert"></span></button>
				--></div>
		  </div>
			<div id="chat_input_cont" class="chat_input_cont">
			<form id="chat_form" >
				<textarea class="form-control input-sm" id="chat_input" name="chat_input" autofocus="autofocus"></textarea>
				<input type="hidden" id="from_user"  name="from_user" value="<?php echo $this->session->userdata('UID'); ?>">
				<input type="hidden" name="to_user" value="<?php echo $chat_user['UID']; ?>">
				<input type="hidden" name="chat_session" value="<?php echo $chat_session; ?>">
			</form>	
			</div>
			
		</div>
	</div>
</div>
<script language="javascript">
	$(document).ready(function(){
		var HHIMS_chat = new Chat();
		HHIMS_chat.get_message_url = "<?php echo base_url(); ?>index.php/chat/get_message/<?php echo $chat_session; ?>";
		HHIMS_chat.send_message_url = "<?php echo base_url(); ?>index.php/chat/send_message";
		HHIMS_chat.chat_close_url = "<?php echo base_url(); ?>index.php/chat/close/<?php echo $chat_session; ?>";
		HHIMS_chat.tittle = "<?php echo $chat_user["FirstName"]; ?>";
		HHIMS_chat.session = "<?php echo $chat_session; ?>";
		HHIMS_chat.me = "<?php echo $this->session->userdata("UID"); ?>";
		HHIMS_chat.run();
		(function 	get_session_messages() {
			var that = HHIMS_chat;
			var request = $.ajax({
				url: that.get_message_url,
				type: "post"
			});
			request.done(function (response, textStatus, jqXHR){
					var msg = eval('(' + response + ')');
					if ((msg) && (msg.length>0)){
						text_msg ='';
						for(var i=0;i<msg.length;i++){
							text_msg += '<b>';
							if (msg[i].FROM_ID == HHIMS_chat.me){
								text_msg += 'Me';
							}
							else{
							text_msg += msg[i].FromUser;
							}
							text_msg +=':</b> <span class="pull-right label label-default">'+msg[i].SentAt+'</span><br>';
							text_msg += msg[i].Message+': <hr style="padding:0px;margin:0px;border:1px solid #cccccc;">';
						}
						$("#chat_content").html(text_msg).scrollTop($("#chat_content").get(0).scrollHeight);
					}
			});
			chat_timer = setTimeout(get_session_messages, 2000); 		
		}())
	});
</script>
</body>
</html>