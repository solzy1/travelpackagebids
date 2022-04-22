<?php 
    $title = "Package"; // set the page title

    require_once $_SERVER['DOCUMENT_ROOT'].'/app/src/package/_package.php'; // require the layout file
    require_once 'layout.php'; // require the layout file

    function body(){
        $request = isset($_GET['package']) ? $_GET['package'] : '';

        $package = new _Package($request);

        $package->show(); // show package
    }
?>