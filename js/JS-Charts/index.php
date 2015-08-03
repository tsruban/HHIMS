<!--
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
-->
<?php
session_start();
if (!session_is_registered(username)) {
    header("location: http://".$_SERVER['SERVER_NAME']);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" type="image/ico" href="images/mds-icon.png">
<link rel="shortcut icon" href="images/mds-icon.png">
<title>MDSFoss</title>
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/browser.detect.js"></script> 
<script language="javascript">

</script>
</head>
<body style="padding:0px;margin:0px;background-color:#f1f1f1 ">
    <div style='position: absolute;top:100px;left:50%;width:450px;'>
                   MDSFoss - Free Patient Record System                    <br>
            Copyright (c) 2011 Net Com Technologies (Sri Lanka)            <br>
            <a href="http://www.mdsfoss.org"  target="_blanck"> MDSFoss.org </a><br>
  ------------------------------------------------------------------------ <br>
  This program is free software; you can redistribute it and/or modify     <br>
  it under the terms of the GNU General Public License as published by     <br>
  the Free Software Foundation.                                            <br>

  You may not change or alter any portion of this comment or credits       <br>
  of supporting developers from this source code or any supporting         <br>
  source code which is considered copyrighted (c) material of the          <br>
  original comment or credit authors.                                      <br>
                                                                           <br>
  This program is distributed in the hope that it will be useful,          <br>
  but WITHOUT ANY WARRANTY; without even an implied warranty of            <br>
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            <br>
  GNU General Public License for more details.                             <br>
                                                                           <br>
  You should have received a copy of the GNU General Public License        <br>
  along with this program; if not, write to:                               <br>
  Free Software  MDSFoss                                                   <br>
  C/- Net Com Technologies,                                                <br>
  15B Fullerton Estate II,                                                 <br>
  Gamagoda, Kalutara, Sri Lanka                                            <br>
  ------------------------------------------------------------------------ <br>
  Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org       <br>
  Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com          <br>
 <a href="http://www.mdsfoss.org"  target="_blank">URL: MDSFoss.org </a><br>
 ------------------------------------------------------------------------- <br>   
        
    </div>
</body>
</html>