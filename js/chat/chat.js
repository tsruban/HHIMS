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

function Chat(){
	this.version = 1;
	this.chat_div = "chat_content";
	this.chat_input = "chat_input";
	this.session = null;
	this.me = null;
	this.tittle = null;
	this.user = new Array();
	this.get_message_url = "null";
	this.send_message_url = "null";
	this.chat_close_url = "null";
	

	
	this.send_message = function(){
		var that = this;
		var data = $("#chat_form").serialize();
		if ($.trim($("#"+that.chat_input).val()) == ""){
			$("#"+that.chat_input).val('');
			return;
		}
		var send_request = $.ajax({
			url: that.send_message_url,
			type: "post",
			data:data
		});
		send_request.done(function (response, textStatus, jqXHR){
			if (response){
				$("#"+that.chat_input).val('');
				that.append_message();
			}
		});	
	};
	this.send_close_message = function(){
		var that = this;
		$("#"+that.chat_input).val("Closed the chat session");
		var data = $("#chat_form").serialize();

		var send_request = $.ajax({
			url: that.send_message_url,
			type: "post",
			data:data
		});

		send_request.done(function (response, textStatus, jqXHR){
			if (response){
				var request1 = $.ajax({
					url: that.chat_close_url,
					type: "post"
				});
				
				request1.done(function (response, textStatus, jqXHR){
					if (response){
						opener.chat_win = null;
						window.close();
					}
				});
			}
		});	
	}
	this.append_message = function(){
	
	}
	this.run = function(){
		var that = this;
		window.document.title = this.tittle + " - Me " + "Chat";
		$(window).unload( function () { 
				//that.chat_close();
		} );
		$(document).ready(function(){
			//Close button
			$("#close_button").click(function(){
				that.chat_close();
			});
			
			//input key press
			$("#"+that.chat_input).keypress(function(event) {
				if ( event.which == 13 ) {
					 event.preventDefault();
					 that.send_message();
				}
			});
			//input key press END
			
			$("#share_button").click(function(){
				url = opener.location;
				$("#chat_input").html('<a href = "'+url+'" target="_blank">[ SHARED SCREEN ]</a>');
				that.send_message();
			});
		});
	};
	this.chat_close = function(){
	
		this.send_close_message();

	};
};