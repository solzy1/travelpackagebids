<?php 
    $title = "Home"; // set the page title
    // $signup_first = modal_content(); // sign up now, content

    require_once 'layout.php'; // require the layout file

    function body($packages = []){
        $page = isset($_GET['page']) ? $_GET['page'] : '';
?>
        <h2>Browse Latest Travel packages</h2>
                
        <br>
        
        <!-- main body -->
        <div class="row" style="padding-left: 17px;">
            <?php 
                $packages->show($page);
            ?>
        </div>
        <?php 
            $packages->pagination($page);
        ?>
		
        <!-- main body (end) -->
<?php 
    }
?>