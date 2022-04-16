<?php
	// start session
	start_session();

	// go to the specified url
	function gotopage($url){
		header("Location: ".$url);
	}

	// START SESSION, IF IT DOESN'T ALREADY EXIST
	function start_session(){
		if (session_status() == PHP_SESSION_NONE) {
	    	session_start();
	    }
	}

	// set the SESSION response, for the request and go the the specified page
	function reportfailure($statusmessage, $page = "sign-in"){
		// set response, to be shown to the user after page failure
		setresponse($statusmessage);

		gotopage('/travelpackagebids/user/'.$page.'.php');
	}

	function setresponse($response){
		$_SESSION['travelpackagebids.com']['status'] = $response;
	}

	// get the response
	function getresponse(){
		return isset($_SESSION['travelpackagebids.com']['status']) ? 
			$_SESSION['travelpackagebids.com']['status'] : '';
	}

	// rest session values
	function reset_sessionvalues(){
		unset($_SESSION['travelpackagebids.com']['status']);
	}

	function set_responsevalues($status, $is_success){
		$_SESSION['travelpackagebids.com']['status'] = $status;
        $_SESSION['travelpackagebids.com']['status_issuccess'] = $is_success;
	}

	function unset_responsevalues(){
		unset($_SESSION['travelpackagebids.com']['status']);
        unset($_SESSION['travelpackagebids.com']['status_issuccess']);
	}

	function get_userid(){
		return isset($_SESSION['travelpackagebids.com']['user_id']) ? 
			$_SESSION['travelpackagebids.com']['user_id'] : 0;
	}

	function format_date($format, $date){
		return date($format, strtotime($date));
	}

	function is_userloggedin(){
		$user_id = get_userid();
		$user_loggedin = $user_id > 0 && loggedin() ? 'yes' : 'no'; // check if userid is set and loggedin is set to true

		return $user_loggedin;
	}

	// check if the session value loggedin, is set to true
	function loggedin(){
		if(isset($_SESSION['travelpackagebids.com']['loggedin']))
			return $_SESSION['travelpackagebids.com']['loggedin'];

		return false;
	}
	
	function configure_page($page, $noof_pages){
		if($page=='first' || empty($page))
			$page = 1;
		else if($page=='last')
			$page = $noof_pages;

		return $page;
	}

	function noof_pages($items, $noof_items){
		$noof_pages = ceil(count($items)/$noof_items); // no of pages

		return $noof_pages;
	}
	
	function pagination($page, $items, $base_url, $noof_items){
		$noof_pages = noof_pages($items, $noof_items); // no of pages
		$last_page = $noof_pages;

		$disable_firstpage = $page<=1 || $noof_pages<=1 || $page=='first' || empty($page) ? 'disabled' : '';
		$disable_lastpage = $page==$last_page || $page=='last' || $noof_pages<=1 ? 'disabled' : '';
	?>
        <!-- pagination -->
        <nav aria-label="Page navigation" style="margin-top: 20px;">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo $disable_firstpage; ?>">
                    <a class="page-link" href="<?php echo $base_url; ?>page=first" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item <?php echo $disable_firstpage; ?>">
                    <a class="page-link" href="<?php echo $base_url; ?>page=1">1</a>
                </li>
                <?php
                	for ($i=1; $i < $noof_pages; $i++) {
                		$curr_page = $i + 1;
                		$disabled = $page==$curr_page || ($curr_page==$noof_pages && $page=='last') ? 'disabled' : ''; // if you move the current page

                		$page_item = '<li class="page-item '.$disabled.'">
                    					<a class="page-link" href="'.$base_url.'page='.$curr_page.'">'.$curr_page.'</a>
                					</li>';

                		echo $page_item;
                	}
                ?>
                <li class="page-item <?php echo $disable_lastpage; ?>">
                    <a class="page-link" href="<?php echo $base_url; ?>page=last" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
	<?php
	}

	function useris_admin(){
		if(isset($_SESSION['travelpackagebids.com']['is_admin']))
    		return $_SESSION['travelpackagebids.com']['is_admin'];

    	return false;
	}

	// ADMIN
	function set_searchvalues($parent, $search, $filter){
		$_SESSION['travelpackagebids.com'][$parent]['search'] = $search;
		$_SESSION['travelpackagebids.com'][$parent]['filter'] = $filter;

		return array('value' => $search, 'filter' => $filter);
	}

	function get_searchvalues($parent){
		$web = $_SESSION['travelpackagebids.com'];

		$search = isset($web[$parent]['search']) ? $web[$parent]['search'] : '';
		$filter = isset($web[$parent]['filter']) ? $web[$parent]['filter'] : '';

		return array('value' => $search, 'filter' => $filter);
	}

    function deactivate($de_activate){
    	if($de_activate){
    		return 'pointer-events: none; text-decoration: none; cursor: not-allowed; opacity: 0.4';
    	}

    	return '';
    }
?>