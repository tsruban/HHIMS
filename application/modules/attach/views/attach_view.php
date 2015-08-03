 <html>
    <head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <title>Attachment</title>
	 <?php
		echo "<link rel='icon' type='image/ico' href='". base_url()."images/mds-icon.png'>";
		echo "<link rel='shortcut icon' href='". base_url()."images/mds-icon.png'>";


		echo "<script type='text/javascript' src='".base_url()."/js/jquery.js' ></script>";
	?>
	</head>	
  <body style='background:#aaaaaa;'>
  <table border=1 bordercolor='#000000' width=100% height=90% style='background:#555555;font-family:Arial;color:#F1F2F2;'>
  <tr><td colspan=2 id='file' style='font-size:14;'><b>HHIMS Attachment<b></td></tr>
  <tr><td width=70% height=100% id='info'><iframe width=100% height=100% src="../../.<?php echo $attach["Attach_Link"]; ?>">
  <img />
  </iframe>
  </td>
  <td valign='top'>
	  <table width=100% border=0 cellspacing=1 cellpadding=2 style='background:#555555;font-family:Arial;color:#F1F2F2;font-size:12px;'>
	  <tr><td width=25% valign=top>Patient : </td><td><?php 
	  echo $patient["Full_Name_Registered"]. '  ';
	  echo $patient["Personal_Used_Name"];
	  ?> </td></tr>
	  <tr><td width=25% valign=top>Patient ID : </td><td><?php echo $patient["PID"]; ?> </td></tr>
	  <tr><td width=25% valign=top>Patient HIN : </td><td><?php echo $patient["HIN"]; ?> </td></tr>
	  <tr><td valign=top>Sex : </td><td><?php echo $patient["Gender"]; ?> </td></tr>
	  <tr><td valign=top>Age : </td><td><?php 
	  echo $patient["Age"]["years"].' Years '; 
	  echo $patient["Age"]["months"].' Months'; 
	  ?> </td></tr>
	  <tr><td valign=top>Address : </td><td><?php echo $patient["Address_Village"]; ?> </td></tr>
	  <tr><td valign=top colspan=2><hr></td></tr>
	  <tr><td width=25% valign=top>FileName : </td><td><?php echo $attach["Attach_Name"]; ?> </td></tr>
	  <tr><td valign=top>Date : </td><td><?php echo $attach["CreateDate"]; ?> </td></tr>
	  <tr><td valign=top>Type : </td><td><?php echo $attach["Attach_Type"]; ?> </td></tr>
	  <tr><td valign=top>Remarks : </td><td><?php echo $attach["Attach_Description"] ?> </td></tr>
	  <tr><td valign=top colspan=2><hr></td></tr>
	  <!--
	  <tr><td valign=top colspan=2 style='background:#f1f1f1;color:#000000;'>Comments:
	  <div id='other_comments'>
	  <?php //echo $getComments(); ?>
	  </div>
	  <tr><td valign=top colspan=2>Your Comments:<br>
	  <textarea style='width:350;height:100;' id='comment'> </textarea>
	  <input type='button' value='Add' onclick=addComment('<?php echo $_SESSION["UID"]; ?>','<?php echo $getValue("ATTCHID"); ?>')>
	  </td></tr>
	  -->
	  </table>
	</td></tr>
  </table>
  <script>
function addComment(uid,attid){
		var reg = /[\<\>\.\'\"\:\;\|\{\}\[\]\,\=\+\-\_\!\~\`\(\)\$\#\@\^\&\,\d\\/\\?]/;
		var comment = $("#comment").val().replace(reg,'');
		var result = $.ajax({
			url : "attachment_comment_save.php",
			data:{"UID":uid,"comment":comment,"ATTID":attid},
			global : false,
			type : "POST",
			async : false
		}).responseText;
		if (result!=""){
			$("#other_comments").append(result);
			$("#comment").val("");
		}
}
	
  </script>
  </body>
  </html>