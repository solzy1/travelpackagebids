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

		gotopage('https://travelpackagebids.com/user/'.$page.'.php');
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

    function user_isblocked($user, $all_packages = false){
    	$user_isblocked = false;

    	if(isset($user->blocked_user->id)){
    		if($all_packages)
    			$user_isblocked = $user->blocked_user->all_packages ? true : false;
    		else
    			$user_isblocked = true;
    	}

    	return $user_isblocked;
    }

    function set_biddingvalues($package, $action){
    	if(isset($package['package_id']) && is_numeric($package['package_id']) && $package['package_id'] > 0){
			$_SESSION['travelpackagebids.com']['bidding']['package_id'] = $package['package_id'];
			$_SESSION['travelpackagebids.com']['bidding']['package_title'] = $package['package_title'];
			$_SESSION['travelpackagebids.com']['bidding']['action'] = $action;
		}

		return array('package_id' => $package['package_id'], 'package_title' => $package['package_title'], 'action' => $action);
	}

	function get_biddingvalues(){ 
		$bidding = isset($_SESSION['travelpackagebids.com']['bidding']) ? $_SESSION['travelpackagebids.com']['bidding'] : '';

		$package_id = isset($bidding['package_id']) ? $bidding['package_id'] : '';
		$action = isset($bidding['action']) ? $bidding['action'] : '';
		$package_title = isset($bidding['package_title']) ? $bidding['package_title'] : '';

		return array('package_id' => $package_id, 'package_title' => $package_title, 'action' => $action);
	}

	function filter_packagerequest($request, $object){
		$package = array('country' => '', 'state' => '', 'package_id' => '');

        if(stripos($request, '-') >= 0){
            $request_split = explode('-', $request);

            if(count($request_split)==3){
                // append country, state & packageid... to package
                $package['country'] = validate_request($request_split, 'string', 0, $object);
                $package['state'] = validate_request($request_split, 'string', 1, $object);
                $package['package_id'] = validate_request($request_split, 'int', 2, $object);;
            }
        }

        return $package;
	}

	function validate_request($arr, $type, $index, $object){
		return isset($arr[$index]) ? $object->validate($type, $arr[$index]) : '';
	}
?>