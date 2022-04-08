class Countries {
    constructor(){

    }

    // load the json file, containing the COUNTRIES & STATES
    load_json(){
        let all_countries = [];

        $.getJSON('/js/json/countries+states.json', function (resp) {
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

                let pair = {country: country.name, states: states};
                all_countries.push(pair);

                _countries.append_select(pair.country, "#package-country");
            }
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

        $("#package-country").on('change', function(){
            let country = $(this).val();

            let found = _countries.find_country(countries, country); 

            let default_option = "<option selected>Select State</option>";
            $("#package-state").html(default_option);

            _countries.append_states(found);
        });
    }

    append_select(option_value, sel){
        let option = "<option value='"+option_value+"'>"+option_value+"</option>";
        $(sel).append(option);
    }
}