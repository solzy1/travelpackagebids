class Packages {
	constructor(countries){
		this.countries = countries;
	}

	// profile (EDIT)
	edit_package(_thispackages){
		$('.edit-package').click(function(){
			let package_id = $.trim($(this).children('.package_id').val());

			$('#package-id').val(package_id); // set the package id

			const _packages = new Packages();

			this.countries = _thispackages.countries; // countries list

			_packages.get_packagerequest(package_id, this.countries);
		});
	}

	set_package(apackage, countries){
		$("#package-country").val(apackage.country);
		$("#package-people").val(apackage.people);
		$("#package-from-date").val(apackage.from_date);
		$("#package-to-date").val(apackage.to_date);
		$("#package-description").val(apackage.description);
		$("#package-phonecode").val(apackage.phone_code);

		// set state
		const _packages = new Packages();

		_packages.set_state(apackage.state, countries);
	}

	set_state(state, countries){
		let country = $("#package-country").val();
		
		let package_state = $("#package-state");
		package_state.children('option:gt(0)').remove(); // remove all the options for states

		if(countries.length > 0){
			const _countries = new Countries();

	        _countries.append_statestoselect(countries, country); // append states to countries
    	}

    	package_state.val(state); // select the new value, for state
	}

	get_packagerequest(package_id, countries){
		let apackage = {package_id: package_id};

        $.post("https://travelpackagebids.com/app/src/profile/package/retrieve-package.php", apackage, function(result){
            const _packages = new Packages();

            _packages.handle_response($.trim(result), countries);
        });
	}

	handle_response(result, countries){
		if(result!==''){
			const _packages = new Packages();

			let apackage = JSON.parse(result);

			_packages.set_package(apackage, countries);
		}
	}

	// profile (CREATE)
	reset_createpackage(){
		$('#create-a-package').click(function(){
			let profile_exists = $.trim($('#profile-exists').val());

			if(profile_exists){
				// reset package id
				$('#package-id').val('');

				// reset the others
				const _package = new Packages();

				let apackage = {country: 'Select Country', state: 'Select State', people: '', 
				from_date: '', to_date: '', description: '', phone_code: ''};

				_package.set_package(apackage, []);
			}
			else{
				let url = 'https://travelpackagebids.com/user/profile.php?user=member';
				let signup_first = '<div class="text-center"><p class="lead">You must <a href="'+url+'">'+
				'update your profile</a>, before you create a package.</p><p class="lead">Kindly <a href="'+url+'">'+
				'update your profile</a>, to create your first travel package.</p></div>';

				$('.create-package-body').html(signup_first);
			}
		});
	}

	// DELETE PACKAGE
	delete_package(){
		$('.delete-package').click(function(){
			let package_id = $.trim($(this).children('.package_id').val());

			$('#package-id').val(package_id); // set the package id

			const _packages = new Packages();

			_packages.send_deleterequest(package_id);
		});
	}

	send_deleterequest(package_id){
		let apackage = {package_id: package_id};

        $.post("https://travelpackagebids.com/app/src/profile/package/delete-package.php", apackage, function(result){
			window.location.replace('https://travelpackagebids.com/user/profile.php');
        });
	}

	// BIDS
	view_bids(){
		$('.view-bids').click(function(){
            const _packages = new Packages();

            let package_id = _packages.get_value(this, '.package_id');
            let is_owner = _packages.get_value(this, '.is_owner');
            
            _packages.get_offers(package_id, is_owner); 

            $('#modal-package-bids').modal('show');
        });
	}

	get_value(parent, child){
        let item = $.trim($(parent).children(child).val());

        return item;
	}

    get_offers(package_id, is_owner){
        let bid = {package_id: package_id, is_owner: is_owner};

        $.post("https://travelpackagebids.com/app/src/bids/get-bids.php", bid, function(result){
            const _packages = new Packages();

            _packages.getoffers_response($.trim(result));
        });
    }

    getoffers_response(result){
        $('#package-bids').html(result);
    }
}