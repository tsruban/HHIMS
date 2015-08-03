<?php
if ((isset($patient_history_list))&&(!empty($patient_history_list))){			
	echo '<div class="panel panel-default"  style="padding:2px;margin-bottom:1px;" >';
		echo '<div class="panel-heading"  style="background:#ffffff;" ><b>Past history</b></div>';
			echo '<table class="table table-condensed table-hover"  style="font-size:0.95em;margin-bottom:0px;cursor:pointer;">';
			for ($i=0;$i<count($patient_history_list); ++$i){
				echo '<tr onclick="self.document.location=\''.site_url("form/edit/patient_history/".$patient_history_list[$i]["PATHISTORYID"]).'?CONTINUE='.$continue.'\';">';
				echo '<td>';
				echo $patient_history_list[$i]["HistoryDate"];
				echo '</td>';
				echo '<td>';
				echo $patient_history_list[$i]["SNOMED_Text"];
				echo '</td>';

				echo '<td>';
			   // echo 'By: '.$patient_history_list[$i]["CreateUser"];
				echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
	echo '</div>';	
}
?>	