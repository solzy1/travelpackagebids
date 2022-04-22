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
});

const bid_status = function(_this){
	const _bids = new Bids();

	_bids.activate(_this);
}