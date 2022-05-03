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

        $.post("/travelpackagebids/app/src/profile/package/retrieve-package.php", apackage, function(result){
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
				let url = '/travelpackagebids/user/profile.php?user=member';
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

        $.post("/travelpackagebids/app/src/profile/package/delete-package.php", apackage, function(result){
			window.location.replace('/travelpackagebids/user/profile.php');
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

        $.post("/travelpackagebids/app/src/bids/get-bids.php", bid, function(result){
            const _packages = new Packages();

            _packages.getoffers_response($.trim(result));
        });
    }

    getoffers_response(result){
        $('#package-bids').html(result);
    }

    // configure date
    configure_date(){
    	const _packages = new Packages();

    	let today = _packages.getmin_date();
    	let tomorrow = _packages.setmin_todate(today);

    	$("#package-from-date").attr('min', today);
    	$("#package-to-date").attr('min', tomorrow);
    }	

    getmin_date(today = ''){
    	if(today==='')
    		today = new Date();

    	let dd = today.getDate();
    	let mm = today.getMonth() + 1;
    	let yyyy = today.getFullYear();

    	if(dd < 10){
    		dd = '0' + dd;
    	}
    	if(mm < 10){
    		mm = '0' + mm;
    	}

    	today = yyyy+'-'+mm+'-'+dd;

    	return today;
    }

    setmin_todate(today){
    	const _packages = new Packages();

    	let date = new Date(today);
    	date.setDate(date.getDate() + 1); // increase day by 1

    	let tomorrow = _packages.getmin_date(date);

    	return tomorrow;
    }

    set_date(){
    	$("#package-from-date").on('change', function(){
    		var from_date = $(this).val();
    		var to_date = $("#package-to-date").val();

    		const _packages = new Packages();

    		let from_dateisgreater = _packages.checkdate(from_date, to_date);
    		to_date = from_dateisgreater ? '' : to_date;

			let tomorrow = _packages.setmin_todate(from_date);

    		$("#package-to-date").attr('min', tomorrow).val(to_date);
    	});
    }

    checkdate(from, to){
    	let from_date = new Date(from).getTime();
    	let to_date = new Date(to).getTime();

    	if(from_date >= to_date)
    		return true;

    	return false;
    }
}