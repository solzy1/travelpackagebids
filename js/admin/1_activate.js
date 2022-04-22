class Activate{
	constructor(){

	}

	// ACTIVATE or DEACTIVATE SINGLE ROWS
	activate(){
		$(".row-activate, .row-deactivate").click(function(){
			let is_activate = $(this).hasClass('row-activate');
			let status = is_activate ? 'active' : 'inactive';

			const _list = new List();

			let page_data = _list.get_pagedata(this, 'update-status.php');

			let data = {id: page_data.row_id, status: status};

			const _activate = new Activate();

			_activate.send_actionrequest(data, page_data.url, this);
		});
	}

	send_actionrequest(data, url, _this){
		$.post(url, data, function(result){
        	if($.trim(result)=='success'){
        		const _list = new List();

				_list.toggle_btn(data.id, _this); // de-activate button
			}
        });
	}

	// ACTIVATE or DEACTIVATE MULTIPLE ROWS
	activate_multiple(){
		$("#rows-activate, #rows-deactivate").click(function(){
			const _list = new List();

			let ids = _list.get_selectedrows();

			if(ids.length > 0){
				const _activate = new Activate();

				_list.toggle_btn(0, this); // deactivate this button

				let is_activate = $(this).prop('id')=='rows-activate';
				let status = is_activate ? 'active' : 'inactive';

				let data = {id: ids, status: status};

				_activate.send_activaterequest(data);
			}
			else {
				alert('No row was selected! Kindly select a row.');
			}
		});
	}

	send_activaterequest(data){
		const _list = new List();

		let url = _list.get_pageurl('update-status.php');

		$.post(url, data, function(result){
			location.reload();
        });
	}
}