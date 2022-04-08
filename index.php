<?php 
    $title = "Home"; // set the page title
    // $signup_first = modal_content(); // sign up now, content

    require_once 'layout.php'; // require the layout file

    function body($packages = []){
?>
        <h2>Browse Latest Travel packages</h2>
                
        <br>
        
        <!-- main body -->
        <div class="row" style="padding-left: 17px;">
            <?php 
                $packages->show();
            ?>
        </div>
        <!-- main body (end) -->
<?php 
    }
?>