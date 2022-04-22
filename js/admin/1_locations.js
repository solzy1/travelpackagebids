class Locations{
	constructor(){

    }
    
    // CREATE LOCATION
    appenduser_tolocation(){
        $('.row-create-location, .view-locations').click(function(){
            let user_id = $.trim($(this).children('.user-id').val());

            $('#user-id').val(user_id);
        })
    }

    create_location(){
        $('#location-submit').click(function(){
            let country = $.trim($(".agent-country").val());
            let state = $.trim($(".agent-state").val());
            const _location = new Locations();

            // if a country and a state was selected
            if(country!==''){
                let user_id = $("#user-id").val();
                let phone_code = $('.phone-code').val();

                let location = {user_id: user_id, country: country, state: state, phone_code: phone_code};

                _location.send_agentlocation(location); // send country, state and user's id
            }
            else {
                _location.report_status('failure', 0, 'Please select a country!');
            }
    	});
    }

    send_agentlocation(location){
        $.post("https://travelpackagebids.com/app/src/admin/travel_agents/locations/receive.php", location, function(result){
            const _location = new Locations();

            _location.report_status($.trim(result), location.user_id, 
                {success: 'Agent\'s location saved successfully!', 
                failure: 'Agent\'s Location was not saved.', container: '.create-location-status'});
        });
    }

    report_status(result, user_id, response){
        let status = {icon: '', message: '', backcolor: ''};

        if(result=='success'){
            status.icon = 'check';
            status.message = response.success;
            status.backcolor = 'green';

            // reload the locations
            const _locations = new Locations();
            
            // get the countrys so far and display it, for the user
            _locations.get_locations(user_id);
        }
        else{
            status.icon = 'exclamation';
            status.message = response.failure;
            status.backcolor = 'red';

            if(result!='failure'){
                status.message += ' '+result;
            }
        }

        let content = '<i class="fa-solid fa-circle-'+status.icon+'"></i> <span style="margin-left: 2px;">' + 
            status.message + '</span>';

        $(response.container)
        .html(content)
        .css({'background-color': status.backcolor})
        .removeClass('d-none');
    }

    on_modalhidden(){
        let create_bid = document.getElementById('create-agent-location');

        create_bid.addEventListener('hidden.bs.modal', function () {
            $('.create-location-status, .location-list-status').addClass('d-none');
            
            $('#agent-locations').html('');
        })
    }

    // LIST LOCATIONS
    on_modalshown(){
        let create_bid = document.getElementById('create-agent-location');

        create_bid.addEventListener('shown.bs.modal', function () {
            let user_id = $("#user-id").val();
            
            // reload the locations
            const _locations = new Locations();
            
            // get the countrys so far and display it, for the user
            _locations.get_locations(user_id);
        })
    }

    get_locations(user_id){
        let location = {user_id: user_id};

        $.post("https://travelpackagebids.com/app/src/admin/travel_agents/locations/get-locations.php", 
            location, function(result){
            const _location = new Locations();

            _location.getlocations_response($.trim(result));
        });
    }

    getlocations_response(result){
        $('#agent-locations').html(result);
    }

    // DELETE LOCATIONS
    delete(_this){
        let parent = $(_this).parent();

        let location_id = $.trim(parent.children('.location-id').val());
        let is_country = $(_this).hasClass('delete-country') ? 'yes' : 'no';

        // SEND DELETE REQUEST
        const _location = new Locations();

        let location = {location_id: location_id, is_country: is_country};

        _location.send_deleterequest(location, _this);
    }

    send_deleterequest(location, _this){
        $.post("https://travelpackagebids.com/app/src/admin/travel_agents/locations/delete.php", 
            location, function(result){
            const _location = new Locations();

            _location.handle_deleteresponse($.trim(result), _this, location);
        });
    }

    handle_deleteresponse(result, _this, location){
        let user_id = !isNaN(result) && result > 0 ? result : 0;
        result = user_id > 0 ? 'success' : 'failure';

        const _location = new Locations();
        
        _location.report_status($.trim(result), user_id, 
                {success: 'Location was removed successfully!', 
                failure: 'Location was not removed!', container: '.location-list-status'});
    }
}