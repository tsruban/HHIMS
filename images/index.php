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
    <div style='position: absolute;top:100px;left:50%;width:600px;'>
--------------------------------------------------------------------------------<br>
HHIMS - Hospital Health Information Management System<br>
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka<br>
<a href='http://www.hhims.org' target='_blank'>www.hhims.org</a><br>
----------------------------------------------------------------------------------<br>
This program is free software: you can redistribute it and/or modify it under the<br>
terms of the GNU Affero General Public License as published by the Free Software <br>
Foundation, either version 3 of the License, or (at your option) any later version.<br>
<br>
This program is distributed in the hope that it will be useful,but WITHOUT ANY <br>
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR <br>
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.<br>
<br>
You should have received a copy of the GNU Affero General Public License along <br>
with this program. If not, see <http://www.gnu.org/licenses/> or write to:<br>
Free Software  HHIMS<br>
C/- Lunar Technologies (PVT) Ltd,<br>
15B Fullerton Estate II,<br>
Gamagoda, Kalutara, Sri Lanka<br>
---------------------------------------------------------------------------------- <br>
Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org<br>
Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com<br>
URL: <a href='http://www.hhims.org' target='_blank'>www.hhims.org</a><br>
----------------------------------------------------------------------------------<br>
        
    </div>
</body>
</html>