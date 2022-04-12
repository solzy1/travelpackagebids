<?php
    require_once 'list.php';
    require_once 'model.php';

    if(isset($_POST['package_id'])){
        // pass the validated values to the receiving class (check if they're correct)
        $bid = new Bid('', $_POST['package_id']);

        $list = new List_Bids($bid);

        $list->bid_offers($_POST['is_owner']);
    }
?>