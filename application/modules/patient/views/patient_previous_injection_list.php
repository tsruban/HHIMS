<?php
if(isset($previous_injection_list)){
	for ($i=0;$i<count($previous_injection_list);++$i){
		echo '<a title="Continue This" href="javascript:void(0)" onclick=inj_continue("'.$previous_injection_list[$i]['injection_id'].'")>'.$previous_injection_list[$i]['CreateDate'].':'.$previous_injection_list[$i]['name'].'<br></a>';
	}
}

?>
<script script="javascript">
function inj_continue(id){
	var r = confirm("Do you want to repeat this injection?");
	if(r){
		$("#injection_id").val(id);
	}
}
</script>