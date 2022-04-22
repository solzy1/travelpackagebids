class Countries {
    constructor(){

    }

    // load the json file, containing the COUNTRIES & STATES
    load_json(){
        let all_countries = [];

        $.getJSON('https://travelpackagebids.com/js/json/countries+states.json', function (resp) {
            const _countries = new Countries();

            for (let i = 0; i < resp.length; ++i) {
                let states = [];

                let country = resp[i];

                let json_states = country.states;
                if(json_states[0]===undefined)
                    continue;

                for (let i = 0; i < json_states.length; ++i) {
                    let state = json_states[i].name;

                    states.push(state);
                }

                let pair = {country: country.name, phone_code: country.phone_code, states: states};
                all_countries.push(pair);

                _countries.append_select(pair.country, ".countries"); // show all the countries for packages
            }

            // show the country of a profile
            _countries.edit_country();
        });
        
        return all_countries;
    }

    find_country(countries, selected_country){
        const found = countries.find(element => element.country==selected_country);

        return found;
    }

    append_states(country){
        const _countries = new Countries();

        let states = country.states;

        for (var i = 0; i < states.length; i++) {
            let state = states[i];

            _countries.append_select(state, "#package-state");
        }
    }

    show_states(countries){
        const _countries = new Countries();

        $("#package-country, #profile-country").on('change', function(){
            let country = $(this).val();

            _countries.append_statestoselect(countries, country);
        });
    }

    append_statestoselect(countries, country){
        // if a country is selected
        if(country!='Select Country'){
            const _countries = new Countries();

            let found = _countries.find_country(countries, country); 

            let default_option = "<option selected>Select State</option>";
            $("#package-state").html(default_option);

            _countries.append_states(found);

            _countries.show_phonecode(found); // show phone code only, on update profile page
        }
    }

    append_select(option_value, sel){
        let option = "<option value='"+option_value+"'>"+option_value+"</option>";
        $(sel).append(option);
    }

    // PHONE CODE
    show_phonecode(country){
        let phone_code_sel = $('.phone-code');
        
        if(phone_code_sel.length > 0){
            let phone_code = country.phone_code;
            
            phone_code_sel.val(phone_code);
            $("#phone-code").html(phone_code);
        }
    }

    // PROFILE
    edit_country(){
        let country = $.trim($('#profile-country').next('input').val());

        $('#profile-country').val(country);
    }
}