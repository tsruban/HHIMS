<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php 
/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
http: www.hhims.org
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see http://www.gnu.org/licenses or write to:
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
 ?>
 

<?php 
include_once("header.php");
    if (isset($_GET['err'])) {
        $err = $_GET['err']; 
    }
	if (isset($_GET["continue"])){
		$continue = $_GET["continue"];
	}
	else{
		$continue = '';
	}
 ?>
</head>
<body >
    <div class="container">
		<form class="form-signin" action="<?php echo base_url(); ?>index.php/login/auth" method="post" accept-charset="utf-8">
			<h2 class="form-signin-heading"><?php echo $title; ?> Login</h2>
			<div class="form-group <?php if (isset($err)>0) echo "has-error"; ?>" >
				<input type="text"  name="username" class="form-control has-error" placeholder="User name" autofocus>
				<input type="password"  name="password" class="form-control" placeholder="Password">
			</div>
			Licensed to: <a href="javascript:void(0)"><?php echo $_SESSION["LIC_HOS"];  ?></a>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
			<input type="hidden" name='LIC' id="LIC" value="<?php echo $_SESSION["LIC"]; ?>" >        
			<input type="hidden" name='continue' id="continue" value="<?php echo $continue; ?>" >  
			<input type="hidden" name='LIC_HOS' id="LIC_HOS" value="<?php echo $_SESSION["LIC_HOS"]; ?>" >
      </form>
	</div>
  <!-- /container -->
  
  <div class="col-md-12 well" >
  <div class="row ">
	<div class="col-md-6 ">	
		<h3>What is HHIMS Foss?</h3>
		<p>
		HHIMS Foss is a Free and Open Source Hospital Health Information Management System that includes a patient record system, a pharmacy management system and a laboratory information system. The system has been developed by the ICT Agency of Sri Lanka in partnership with the Office of the Regional Director of Health Services, Kegalle with technical support from NetCom Technologies, Kalutara. Adapted from a WHO-designed database,  it is equally at home in the out-patient clinic, the ward, the pharmacy and the laboratory as it is when producing public health reports and statistics.    
		</p> 
		<div class="text-center">
			<div >Visit <a href="http://www.hhims.org" target="_blank" ><b>www.hhims.org</b></a> for more details..</div><br>
			 <a href='http://www.gov.lk/' target='_blank'><img src="<?php echo base_url(); ?>images/SriLankalogo.jpg"  height=39></a>
			 <a href='http://www.icta.lk/' target='_blank'><img src="<?php echo base_url(); ?>images/icta-logo.jpg" ></a>
			 <a href='http://www.icta.lk/en/programmes/e-society.html' target='_blank'><img src="images/esrilanka.jpg" ></a>
			 <a href='http://www.icta.lk/' target='_blank'><img src="<?php echo base_url(); ?>images/e-samajaya-logo.jpg" width=101 height=39 ></a>
			 <a href='http://www.hhims.org/' target='_blank'><img src="<?php echo base_url(); ?>images/hhims_white.png" width=101 height=39></a>
			 <a href='http://www.lunartechnologies.net' target='_blank'><img src="<?php echo base_url(); ?>images/lt_logo_tr_100.png" width=40 height=40 ></a>
		</div>
	</div>	
	<div class="col-md-6 ">		
		<ul>
			<li class="xlocal">
			   <h4>Fast</h4>
			   <p>From a single-user laptop in a doctor's practice to a multi-user network in a large hospital, you can enter patient data faster than you can write, and show it on the screen quicker than you can find the patient's old card.</p>
			</li>
			<li class="xlocal">
			   <h4>User friendly</h4>
			   <p>
			   The secret of the system is simplicity. After the half-day training course, even new computer users are able to enter patient information, and choosing from lists such as diseases, drugs or villages takes the guesswork out of data entry.
			  </p>
			</li>
			<li class="xlocal">
			   <h4>Affordable</h4>
				 <p>
			   The software license is free. The only costs are for hardware, installation and training. An optional annual fee provides hot-line support and keeps your system up-to-date with the latest developments.
				</p>
			</li>
		</ul>  

  
  </div>
</div>
  </div> 

</body>
</html>
