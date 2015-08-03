<?php
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
     && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	 //print_r($user_list);
 	for ($i=0; $i <count($user_list);++$i){ 
 		 		
		if ($my_id == $user_list[$i]["UID"]){
		
				if ($user_list[$i]["Status"] == "ON_LINE"){
					echo '<li>';
						echo '<a href="javascript:void(0);">Iam&nbsp;<span class="label label-success">On line</span>&nbsp;<span class="label label-default" onclick=change_status_to("OFF_LINE") >Make me Off line</span></a>';
					echo '</li>';	
				}
				else{
					echo '<li>';
						echo '<a href="javascript:void(0);">Iam&nbsp;<span class="label label-danger">Off line</span>&nbsp;<span class="label label-default"  onclick=change_status_to("ON_LINE") >Make me On line</span></a>';
					echo '</li>';
					exit;
				}
			echo '<li>';
				echo '<a href="'.site_url('user/profile').'">';
					echo '<span class="glyphicon glyphicon-cog" >&nbsp;';
					echo '</span>';
					
				echo 'My Profile/Settings';
				echo '</a>';
			echo '</li>';
				echo '<li>';
				echo '<a href="'.site_url('chat/my_conversations').'">';
					echo '<span class="glyphicon glyphicon-envelope" >&nbsp;';
					echo '</span>';
					
				echo 'Open my conversations&nbsp;';
					if (isset($message_new) &&($message_new>=0)){
						echo '<span class="badge label-success">'.$message_new.'</span>';
					}
				echo '</a>';
			echo '</li>';

			echo '<li role="presentation" class="divider"></li>';
			break;
		}
	}
	for ($i=0; $i <count($user_list);++$i){		
		echo '<li>';
			if (($user_list[$i]["Status"] == "ON_LINE")&&($my_id != $user_list[$i]["UID"])){
				echo '<a href="javascript:void(0);" onclick=load_chat("'.$user_list[$i]["UID"].'"); title="'.$user_list[$i]["FirstName"].' '.$user_list[$i]["FirstName"].'">';
					echo '<span class="glyphicon glyphicon-user" >&nbsp;';
					echo '</span>';
					echo $user_list[$i]["UserName"];
				echo '</a>';
			}
		echo '</li>';
	}

}

else{
	echo 'Nothing here';
}
?>