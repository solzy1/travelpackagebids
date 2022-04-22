$(function () {
	// admin list
	const _list = new List();
	
	_list.check_all();
	_list.check();

	// activate and deactivate
	const _activate = new Activate();

	_activate.activate(); // activate or deactivate row
	_activate.activate_multiple();

	// delete
	const _delete = new Delete();

	_delete.delete(); // delete row
	_delete.delete_multiple();

	// search
	const _search = new Search();

	_search.search();
	_search.onenter();
	_search.append_filtervalue();

	// agent active locations
	const _location = new Locations();

	_location.create_location();
	_location.appenduser_tolocation();
	_location.on_modalhidden();
	_location.on_modalshown();

	// bidding (allow OR prevent)
	const _bidding = new Bidding();

	_bidding.allow_bidding();
	_bidding.allowmultiple_bidding();
});

const bid_status = function(_this){
	const _bids = new Bids();

	_bids.activate(_this);
}

const delete_location = function(_this){
	const _location = new Locations();

	_location.delete(_this);	
}