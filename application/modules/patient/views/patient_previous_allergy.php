<?php
if ((isset($patient_allergy_list))&&(!empty($patient_allergy_list))){			
	echo '<div class="panel  panel-default"  style="padding:2px;margin-bottom:1px;" >';
		echo '<div class="panel-heading"  style="background:#ffffff;" ><b>Allergies</b></div>';
			echo '<table class="table table-condensed table-hover"  style="font-size:0.95em;margin-bottom:0px;cursor:pointer;">';
			for ($i=0;$i<count($patient_allergy_list); ++$i){
				echo '<tr onclick="self.document.location=\''.site_url("form/edit/patient_alergy/".$patient_allergy_list[$i]["ALERGYID"]).'?CONTINUE='.$continue.'\';">';
					echo '<td>';
						echo $patient_allergy_list[$i]["CreateDate"];
					echo '</td>';
					echo '<td>';
						echo $patient_allergy_list[$i]["Name"];
					echo '</td>';
					echo '<td>';
						if ($patient_allergy_list[$i]["Status"]=="Current"){
							echo '<span class="label label-danger">'.$patient_allergy_list[$i]["Status"].'</span>';
						}
						else{
							echo '<span class="label label-warning">'.$patient_allergy_list[$i]["Status"].'</span>';
						}
					echo '</td>';
					echo '<td>';
						echo $patient_allergy_list[$i]["Remarks"];
					echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
	echo '</div>';	
}
?>		