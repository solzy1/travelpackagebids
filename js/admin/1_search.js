class Search{
	constructor(){

	}

	append_filtervalue(){
		let filter = $.trim($('#search-filter').next('.search-filter').val());

		$('#search-filter').val(filter);
	}

	search(){
		$('#send-search').click(function(){
			const _search = new Search();

			_search.send_search();
		});
	}

	onenter(){
		$('#search').on('keyup', function(event){
			if(event.keyCode === 13) {
				const _search = new Search();

				_search.send_search();
			}
		});
	}

	send_search(){
		const _search = new Search();

		let data = _search.search_input();

		_search.send_request(data);
	}

	search_input(){
		let search = $.trim($('#search').val());
		let filter = $.trim($('#search-filter').val());

		return {search: search, filter: filter};
	}

	send_request(data){
		const _list = new List();

		let url = _list.get_pageurl('search.php');

		$.post(url, data, function(result){
			location.reload();
        });
	}
}