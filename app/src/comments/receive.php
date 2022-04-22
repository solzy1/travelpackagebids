<?php
	require_once 'create.php';
	require_once 'model.php';

	// pass the validated values to the receiving class (check if they're correct)
	$comment = new Comment($_POST['comment'], $_POST['package_id'], $_POST['comment_id']);

	$create = new Create_Comments($comment);

	$create->comment();
?>