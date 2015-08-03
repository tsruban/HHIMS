<?php
if ((isset($nursing_notes_list))&&(!empty($nursing_notes_list))){			
	echo '<div class="panel  panel-default"  style="padding:2px;margin-bottom:1px;" >';
		echo '<div class="panel-heading"  style="background:#ffffff;" ><b>In-patient nursing notes</b></div>';
			echo '<table class="table table-condensed table-hover"  style="font-size:0.95em;margin-bottom:0px;cursor:pointer;">';
			for ($i=0;$i<count($nursing_notes_list); ++$i){
				echo '<tr onclick="self.document.location=\''.site_url("form/edit/admission_notes/".$nursing_notes_list[$i]["ADMNOTEID"]).'?CONTINUE='.$continue.'\';">';
					echo '<td>';
						echo $nursing_notes_list[$i]["CreateDate"];
					echo '</td>';
					echo '<td>';
						echo $nursing_notes_list[$i]["Note"];
					echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
	echo '</div>';	
}
?>		