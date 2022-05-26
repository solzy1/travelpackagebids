<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $title = "Package"; // set the page title

    require_once $_SERVER['DOCUMENT_ROOT'].'/travelpackagebids/app/src/package/_package.php'; // require the layout file
    require_once 'layout.php'; // require the layout file

    function body(){
        $request = isset($_GET['package']) ? $_GET['package'] : '';

        $package = new _Package($request);
        
        // get the command to save the page, for.. if the user isn't logged in
        $save_page = isset($_GET['save']) ? $_GET['save'] : '';
        
        $package->save_page($save_page);
        
        $package->show(); // show package
    }
?>