class User{
	constructor(){

	}

	logout(){
		$('.logout').click(function(){
			const _user = new User();

			_user.send_request();
		});
	}

	send_request(){
        let bid = {logout: 'yes'};

        $.post("https://travelpackagebids.com/app/src/user/logout.php", bid, function(result){
            if($.trim(result)=='success')
            	window.location.replace("https://travelpackagebids.com");
        });
	}
}