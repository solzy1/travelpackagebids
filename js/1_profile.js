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

	// user
	const _user = new User();

	_user.logout();
	
	// profile menu
	const _profilemenu = new Profile_Menu();
	
	_profilemenu.show_body();
});