<?php
	require_once 'create.php';
	require_once 'model.php';

	// pass the validated values to the receiving class (check if they're correct)
	$bid = new Bid($_POST['offer'], $_POST['package_id']);

	// go to UPDATE, else go to CREATE
	// if(isset($_POST['package_id']) && !empty($_POST['offer'])) {

	// }
	// else{
		$create = new Create_Bids($bid);

		$create->bid();
	// }
?>