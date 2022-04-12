$(function () {
	// confirm email
	const _confirmemail = new Confirm_Email();

	_confirmemail.password_isvalid();
	_confirmemail.repassword_isvalid();
	_confirmemail.submit_password();
});

class Confirm_Email {
	constructor(){

	}

	check_passwords(){
		let password = $.trim($('#password').val());
		let re_password = $.trim($('#re-password').val());

		if(password!==re_password){
			return false;
		}

		return true;
	}

	repassword_isvalid(){
		const _confirmemail = new Confirm_Email();

		$('#re-password').keyup(function(){
			let isvalid = _confirmemail.check_passwords();

			_confirmemail.enable_submit(isvalid); // enable submit button
			_confirmemail.show_error(isvalid, '#re-passwordHelpBlock'); // show re-password error
		});	
	}

	password_isvalid(){
		const _confirmemail = new Confirm_Email();

		$('#password').keyup(function(){
			let password = $.trim($(this).val());
			let is_passwordvalid = password.length >= 8;

			let isvalid = false;

			if(is_passwordvalid){
				let isvalid = _confirmemail.check_passwords();
			}

			_confirmemail.enable_submit(isvalid); // enable submit button
			_confirmemail.show_error(is_passwordvalid, '#passwordHelpBlock'); // show password error
		});	
	}

	enable_submit(isvalid){
		if(!isvalid)
			$("#submit-password").addClass('disabled');
		else
			$("#submit-password").removeClass('disabled');
	}

	show_error(isvalid, sel){
		if(!isvalid)
			$(sel).addClass('text-danger');
		else
			$(sel).removeClass('text-danger');
	}

	submit_password(){
		$("#submit-password").click(function(){
			let password = $.trim($('#password').val());
			let re_password = $.trim($('#re-password').val());
			let key = $.trim($('#key').val());

			const _confirmemail = new Confirm_Email();

			_confirmemail.send_password(password, re_password, key);
		});
	}

	send_password(password, re_password, key){
		let passwords = {password: password, re_password: re_password, key: key};

        $.post("https://travelpackagebids.com/app/src/user/receive-password.php", passwords, function(result){
        	const _confirmemail = new Confirm_Email();
        	
        	_confirmemail.gotopage($.trim(result));
        });
	}

	gotopage(result){
		let url = '/user/profile.php'; // is request was successful

		if(result=='failure')
			url = "";

		window.location.replace(url);
	}
}