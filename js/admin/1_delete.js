class Delete{
	constructor(){

	}

	// DELETE
	delete(){
		$(".row-delete").click(function(){
			const _delete = new Delete();

			let deletenow = _delete.prompt_delete();

			if(deletenow){
				const _list = new List();

				let page_data = _list.get_pagedata(this, 'delete.php');

				let data = {id: page_data.row_id};

				_delete.send_deleterequest(data, page_data.url);
				_list.toggle_btn(0, this); // disable the delete button, until they can delete
			}
		});
	}

	send_deleterequest(data, url){
		$.post(url, data, function(result){
			location.reload();
        });
	}

	prompt_delete(){
		return confirm("Are you sure you want to delete?");
	}

	// DELETE MULTIPLE ROWS
	delete_multiple(){
		$("#rows-delete").click(function(){
			const _list = new List();

			let ids = _list.get_selectedrows();

			if(ids.length > 0){
				const _delete = new Delete();

				let deletenow = _delete.prompt_delete();

				if(deletenow){
					const _delete = new Delete();

					_list.toggle_btn(0, this); // de-activate this button

					let data = {id: ids};

					_delete.send_multideleterequest(data);
				}
			}
			else {
				alert('No row was selected! Kindly select a row.');
			}
		});
	}

	send_multideleterequest(data){
		const _list = new List();

		let url = _list.get_pageurl('delete.php');

		$.post(url, data, function(result){
			console.log(result);
			// location.reload();
        });
	}
}