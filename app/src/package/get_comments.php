<?php
	require_once 'comments.php';

	if(isset($_POST['allow']) && $_POST['allow']=='yes'){
		$display = new Comments();

		$display->comments($_POST['package_id']);
	}
?>