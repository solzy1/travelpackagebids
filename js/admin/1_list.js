class List{
	constructor(){

	}

	check_all(){
		$('#check-all').on('change', function(){
			let is_checked = $(this).prop('checked');

			$('.row-check').prop('checked', is_checked);
		});
	}

	check(){
		$(".row-check").on('change', function(){
			let all_checked = $(".row-check:not(:checked)");
			let checked_all = all_checked.length > 0; // is any checkbox unchecked

			$("#check-all").prop('checked', !checked_all); // if all boxes are checked, check 'check-all', else
		});
	}

	get_pageurl(script){
		let base_url = $.trim($('#page-url').val());
		let url = 'https://travelpackagebids.com/app/src/admin/'+base_url+'/'+script;

		return url;
	}

	get_pagedata(_this, script){
		let row_id = $.trim($(_this).parent().children('.id').val());

		const _list = new List();

		let url = _list.get_pageurl(script);

		return {row_id: row_id, url: url};
	}

	get_selectedrows(){
		let checked_rows = $('.row-check:checked');
		let rows = [];

		for (var i = 0; i < checked_rows.length; i++) {
			rows[i] = checked_rows.eq(i).val();
		}

		return rows;
	}

	toggle_btn(id, _this){
		if(id > 0){
			$('.toggle-activate-'+id).css({'pointer-events': '', 'text-decoration': '', 
				'cursor': 'pointer', 'opacity': ''}); // activate all
		}

		$(_this).css({'pointer-events': 'none', 'text-decoration': 'none', 
				'cursor': 'not-allowed', 'opacity': 0.4}); // deactivate selected
	}
}