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

function Pain_ploater(){
	this.version = 1;
	this.ploter_div = "ploter";
	this.tool_div = "ploter";
	this.spots = new Array();
	
	this.width = "400";
	this.height = "600";
	this.mouse_down = false;
	this.mouse_up = true;
	this.x = null;
	this.y = null;
	this.current_selection=null;
	this.pain_color = [
		{
			"name":"Agonizing",
			"color":"#FF0000"
		},
		{
			"name":"Horrible",
			"color":"#F78B02"
		},
		{
			"name":"Dreadfull",
			"color":"#FFF500"
		},
		{
			"name":"Uncomfortable",
			"color":"#03FF03"
		}
		,
		{
			"name":"Annoying",
			"color":"#0000FF"
		}
		,
		{
			"name":"Mild",
			"color":"#FF00F5"
		}
	];
	this.dx=7;
	this.dy=25;
	this.count=0;
	this.clear = function(){
		this.count=0;
		this.spots = new Array();
		$("#"+this.ploter_div).html("");
	};
	
	this.undo = function(){
		this.spots.pop();
		console.log(this.spots.length);
		var tmp_arr = this.spots;
		this.clear();
		this.plot_all(tmp_arr);
	};
	
	this.plot_all =function(arr){
		for (var i in arr) {
			this.plot (arr[i].x,arr[i].y,arr[i].clr,arr[i].name);
		}
	};	
	
	this.plot = function (x,y,clr,name){
		var spot_css = {
			"position":"absolute",
			"top":y,
			"left":x,
			"z-index":100+this.count,
			"background":clr,
			"width":25,
			"height":25,
			"border-radius":"25px",
			//"-webkit-box-shadow": "6px 6px 6px rgba(0, 0, 0, 0.5)"
			};
			var spot = {
				"x":x,
				"y":y,
				"clr":clr,
				"name":name,
				"remarks":""
			};
			this.spots.push(spot);
			this.count=that.spots.length;
			//console.log(JSON.stringify(this.spots));
			var spot = '<div id="s_'+this.count+'" title="'+name+'"></div>'
			$("#"+this.ploter_div).append(spot);
			$("#s_"+this.count).css(spot_css);
	};
	this.get_data =function(){
		return JSON.stringify(this.spots);
	};
	this.load_data =function(data){
		this.clear();
		this.plot_all(JSON.parse(data));
	};
	this.init = function(div){
		this.ploter_div = div;
		this.current_selection = this.pain_color[5];
		that = this;
		$("#"+this.ploter_div).click(function(e){
			var parentOffset = $(this).parent().offset(); 
			var relX = e.pageX - parentOffset.left+that.dx;
			var relY = e.pageY - parentOffset.top+that.dy;
			that.plot(relX,relY,that.current_selection.color,that.current_selection.name );
		});
	};
	
	this.select_color = function(btn){
		id=$(btn).attr("id");
		if (this.pain_color[id]){
			this.current_selection = this.pain_color[id];
		}
		else{
			this.current_selection = null;
		}
	};
	
	
	this.load_tool = function (div){
		this.ploter_div = div;
		var buttons = '';
		that=this;
		for (var i in this.pain_color) {
			buttons += '<input type="button" id='+i+' onclick=that.select_color(this) color="'+this.pain_color[i].color+'" style="background:'+this.pain_color[i].color+'" value="'+this.pain_color[i].name+'" />';
		}
		buttons += '&nbsp;&nbsp;&nbsp;<input type="button" onclick=that.undo() value="Undo" />';
		buttons += '&nbsp;&nbsp;&nbsp;<input type="button" onclick=that.clear() value="Clear all" />';

		$("#"+this.ploter_div).html(buttons);
	};
	
};
