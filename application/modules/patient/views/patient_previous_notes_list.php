<?php
if(isset($previous_notes_list)){
	for ($i=0;$i<count($previous_notes_list);++$i){
		echo $previous_notes_list[$i]['CreateDate'].':'.$previous_notes_list[$i]['notes'].'<br>';
	}
}

?>
<script script="javascript">

</script>