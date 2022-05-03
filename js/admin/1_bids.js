class Bidding{
	constructor(){

	}

	// ACTIVATE or DEACTIVATE SINGLE ROWS
	allow_bidding(){
		$(".row-allow-bidding").click(function(){
			let allowed_tobid = $(this).hasClass('allow-bidding');
			let status = allowed_tobid ? 'allow' : 'prevent';

			let row_id = $.trim($(this).parent().children('.id').val());

			let url = '/travelpackagebids/app/src/admin/bidding/allow-bidding.php';

			let data = {id: row_id, status: status};

			const _bidding = new Bidding();

			_bidding.send_actionrequest(data, url, this);
		});
	}

	send_actionrequest(data, url, _this){
		$.post(url, data, function(result){
        	if($.trim(result)=='success'){
        		const _bidding = new Bidding();

				_bidding.toggle_btn(_this, data.id); // de-bidding button
			}
        });
	}

	toggle_btn(_this, id){
		if(id > 0){
			$('.allow-bidding-'+id)
				.removeClass('no-bidding');
		}

		$(_this)
			.addClass('no-bidding');
	}

	// ACTIVATE or DEACTIVATE MULTIPLE ROWS
	allowmultiple_bidding(){
		$("#rows-allow-bidding, #rows-prevent-bidding").click(function(){
			const _list = new List();

			let ids = _list.get_selectedrows();

			if(ids.length > 0){
				const _bidding = new Bidding();

				_bidding.toggle_btn(this, 0); // debidding this button

				let allow_bidding = $(this).prop('id')=='rows-allow-bidding';
				let status = allow_bidding ? 'allow' : 'prevent';

				let data = {id: ids, status: status};

				_bidding.send_biddingrequest(data);
			}
			else {
				alert('No row was selected! Kindly select a row.');
			}
		});
	}

	send_biddingrequest(data){
		const _bidding = new Bidding();

		let url = '/travelpackagebids/app/src/admin/bidding/allow-bidding.php';

		$.post(url, data, function(result){
			// console.log(result);
			location.reload();
        });
	}
}