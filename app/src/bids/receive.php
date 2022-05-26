<?php
	require_once 'create.php';
	require_once 'model.php';

	// pass the validated values to the receiving class (check if they're correct)
	if(isset($_POST['offer']) && isset($_POST['package_id']) && isset($_POST['deadline'])){
    	$bid = new Bid($_POST['offer'], $_POST['package_id'], $_POST['deadline']);
    	
    	$itenary_file = isset($_POST['itenary_file']) & !empty($_POST['itenary_file']) ? $_POST['itenary_file'] : '';

    	$create = new Create_Bids($bid, $itenary_file);
    
    	$create->bid();
	}
?>