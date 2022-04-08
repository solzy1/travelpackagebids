$(function () {
	// countries and states
	// const _countries = new Countries();

	// let all_countries = _countries.load_json();
	// _countries.show_states(all_countries);

	// bids/offers
	const _bids = new Bids();

	_bids.show_createoffer();
	_bids.create_offer();
	_bids.on_modalshown();
	_bids.on_modalhidden();
	
	// user
	const _user = new User();

	_user.logout();

	// COMMENTS
	const _comments = new Comments();

	// load comments
	const is_commentactive = $('.loading-comments').html();

	 // only when user is on the comments page
	if(is_commentactive!==undefined){
		let package_id = $.trim($('#package_id').val());
		_comments.load_comments(package_id); // load comments
		
		_comments.prevent_comment();
	}
});

// COMMENTS
const load_comments = function(_comments){
	// _comments.load_comments();
}

const send_comment = function(_this){ // post user's comment, to comments
	const _comments = new Comments();

	_comments.send_comment(_this);
}

const comment_result = function(result, success, failure){
    let status = {icon: '', message: '', backcolor: ''};

    if(result=='success'){
        status.icon = 'check';
        status.message = success;
        status.backcolor = 'green';
    }
    else{
        status.icon = 'exclamation';
        status.message = failure;
        status.backcolor = 'red';
    }

    let content = '<i class="fa-solid fa-circle-'+status.icon+'"></i> <span>'+status.message+'</span>';

    $('.comment-response:eq(0)')
    .html(content)
    .css({'opacity': 1, 'background-color': status.backcolor, 'color': 'white'});
}

const prevent_reply = function(_this){
	if(_this!==undefined){
		const _comments = new Comments();

		_comments.prevent_reply(_this);
	}
}