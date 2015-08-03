<?php
if ((isset($previous_injection_list))&&(!empty($previous_injection_list))){			
	echo '<div class="panel panel-default"  style="padding:2px;margin-bottom:1px;" >';
	echo '<div class="panel-heading"  style="background:#ffffff;" ><b>Previous vaccinations and injections</b></div>';

		echo '<table class="table table-condensed table-hover"  style="font-size:0.95em;margin-bottom:0px;cursor:pointer;">';
		for ($i=0;$i<count($previous_injection_list); ++$i){
			echo '<tr';
			if ($previous_injection_list[$i]["status"] =="Pending"){
				//echo ' onclick = self.document.location="'.site_url("form/edit/opd_injection/".$previous_injection_list[$i]["patient_injection_id"]).'" ';
			}
			echo '>';
			echo '<td width="10px">';
			echo '<a title="Click here to open the related record" class="btn btn-xs ';
			if ($this->uri->segment(3) ==$previous_injection_list[$i]["episode_id"]){
				echo ' btn-warning"';
			}
			else{
				echo ' btn-default"';
			}
			if ($previous_injection_list[$i]["episode_type"] =="OPD"){
				echo ' href="'.site_url("opd/view/".$previous_injection_list[$i]["episode_id"]).'" ';
			}
			if ($previous_injection_list[$i]["episode_type"] =="ADM"){
				echo ' href="'.site_url("admission/view/".$previous_injection_list[$i]["episode_id"]).'" ';
			}
			else{
				echo ' href="#" ';
			}
			echo '>'.$previous_injection_list[$i]["episode_type"].'</a>';
			echo '</td>';
			echo '<td>';
			echo $previous_injection_list[$i]["CreateDate"];
			echo '</td>';
			echo '<td>';
			echo $previous_injection_list[$i]["name"];
			echo '</td>';
			echo '<td>';
			echo $previous_injection_list[$i]["dosage"];
			echo '</td>';
			echo '<td>';
			echo $previous_injection_list[$i]["route"];
			echo '</td>';
			echo '<td>';
			echo $previous_injection_list[$i]["status"];
			echo '</td>';
			echo '</tr>';
		}
		echo '</table>';
	echo '</div>';	
}
?>