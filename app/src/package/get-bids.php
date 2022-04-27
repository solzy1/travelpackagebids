<?php
    require_once '_package.php';

    if(isset($_POST['package_id'])){
        $package = new _Package();

        $package->bids($_POST['package_id']);
    }
?>