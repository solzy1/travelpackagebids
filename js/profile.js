$(function () {
	// countries and states
	const _countries = new Countries();

	let all_countries = _countries.load_json();
	_countries.show_states(all_countries);

	// packages
	const _package = new Packages();

	_package.edit_package();
	_package.reset_createpackage();

	// user
	const _user = new User();

	_user.logout();
});