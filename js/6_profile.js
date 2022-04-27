$(function () {
	// countries and states
	const _countries = new Countries();

	let all_countries = _countries.load_json();
	_countries.show_states(all_countries);

	// packages
	const _package = new Packages(all_countries);

	_package.edit_package(_package);
	_package.reset_createpackage();
	_package.delete_package();
	_package.view_bids();
	_package.configure_date();
	_package.set_date();

	// user
	const _user = new User();

	_user.logout();
	
	// profile menu
	const _profilemenu = new Profile_Menu();
	
	_profilemenu.show_body();

	// validate phone
	validate_phone();

	// BIDS
	const _bids = new Bids();
 
	_bids.show_createoffer();
	_bids.create_offer();
	
    if($('#create-package-bid').length > 0){
    	_bids.on_modalshown();
    	_bids.on_modalhidden();
    }
    
	_bids.activate();
	_bids.prevent_bidding();

});

const validate_phone =  function(){
	$('#profile-phone').on('keyup', function(){
		var phone = $.trim($(this).val());

		if(phone.length > 10){
			phone = phone.substring(0, 10);
			
			$(this).val(phone);
		}
	});
}