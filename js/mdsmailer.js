//  ------------------------------------------------------------------------ //
//                   MDSFoss - Free Patient Record System                    //
//            Copyright (c) 2011 Net Com Technologies (Sri Lanka)            //
//                        <http://www.mdsfoss.org/>                          //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation.                                            //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even an implied warranty of            //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to:                               //
//  Free Software  MDSFoss                                                   //
//  C/- Net Com Technologies,                                                //
//  15B Fullerton Estate II,                                                 //
//  Gamagoda, Kalutara, Sri Lanka                                            //
//  ------------------------------------------------------------------------ //
//  Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org       //
//  Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com          //
//  URL: http://www.mdsfoss.org                                              //
// ------------------------------------------------------------------------- //
function  loadMailer(name,ug,hos){
    $('<div id="mdsmailer" title="MDS Mailer" style="background:#fcfcda; border:1px solid #000000;"></div>').appendTo('body');
    $("#mdsmailer").html("Getting information...");
   
    $("#mdsmailer").html(getPageInfo(name,ug,hos));
    $("#mdsmailer").dialog({
        width:650,
        height:400,
        autoOpen:true,
        modal: true,
        resizable:false,
        position:'center'
    });   
    $('#cap_cont').load("include/getcaptcha.php");
}
function getPageInfo(name,ug,hos){
    var info = "";
    $.getScript("js/browser.detect.js", function() {
        BrowserDetect.init();
         info = BrowserDetect.browser;
         $('#b').val(info);
    });
    
    var out ="";
    //out +="<form id='mailfrm' name='mailfrm' action='include/sendmail.php' method='POST'>";
    out +="<table width=100% border=0 style='font-size:12px;font-family:courier;'>";
        out +="<tr>";
            out +="<td align=right width=100 nowrap>";
                out +="To:";
            out +="</td>";
            out +="<td>";
                out +="<input  disabled readonly style='width:100%' value='TSRuban, DRPole, Gihan' >";
                out +="<input type='hidden' id='ret' name='ret' value='"+escape(self.document.location)+"' >";
                out +="<input type='hidden' id='u' name='u' value='"+name+"' >";
                out +="<input type='hidden' id='ug' name='ug' value='"+ug+"' >";
                out +="<input type='hidden' id='h' name='h' value='"+hos+"' >";
                out +="<input type='hidden' id='url' name='url' value='"+self.document.location+"' >";
                out +="<input type='hidden' id='b' name='b' value='' >";
                
            out +="</td>";
        out +="</tr>";
        out +="<tr>";
            out +="<td align=right width=100>";
                out +="Type:";
            out +="</td>";
            out +="<td>";
                out +="<select id='typ' name='typ'>";
                    out +="<option value='Bug'>Bug</option>";
                    out +="<option value='Suggestions' selected>Suggestions</option>";
                    out +="<option value='Opinions'>Opinions</option>";
                    out +="<option value='Service request'>Service request</option>";
                 out +="</select>";
            out +="</td>";
       out +="</tr>";  
       
        out +="<tr>";
            out +="<td align=right nowrap width=100 valign=top>";
                out +="Message:";
            out +="</td>";
            out +="<td>";
                out +="<textarea id='msg' name='msg'   style='width:100%;height:200px;'>";
                out +="</textarea >";
            out +="</td>";
       out +="</tr>"; 
        out +="<tr>";
            out +="<td align=right nowrap width=100 valign=top>";
            
            out +="</td>";
            out +="<td>";
                out +="<div id='cap_cont'>";
                    
                out +="</div>";
            out +="</td>";
       out +="</tr>"; 
        out +="<tr>";
            out +="<td align=right nowrap width=100 valign=top>";
                out +="";
            out +="</td>";
            out +="<td>";
                out +="<input type='button' class='formButton' value='Send' id='smtbtn' onmousedown='this.value=\" sending...\";' onmouseup='this.disabled=true;submit();' >";
                out +="<input type='button' class='formButton' value='Cancel' onclick=$('#mdsmailer').remove()>";
            out +="</td>";
       out +="</tr>"; 
out +="</table>";
   // out +="</form>";
    return out;
}
function submit(){
    $('#smtbtn').val('Sending....');
    var data=({
            "ret":$('#ret').val(),
            "u":$('#u').val(),
            "ug":$('#ug').val(),
            "h":$('#h').val(),
            "url":$('#url').val(),
            "b":$('#b').val(),
            "typ":$('#typ').val(),
            "msg":$('#msg').val(),
            "capval":$('#capval').val()
        });
    var r=$.ajax({
        url: "include/sendmail.php",
        global: false,
        data:data,
        type: "POST",
        async:false
    }).responseText;
    if (r == -99){
        $('#smtbtn').val('Re-Send').attr('disabled',false);
         $('#chelp').html('Enterd value not correct');
         
         
        $('#cap_cont').load("include/getcaptcha.php");
        return;
    }
    else if(r ==1){
        $('#mdsmailer').remove();
    }
    
    
}