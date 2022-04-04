$(function () {
	const countries = new Countries();

	let all_countries = countries.load_json();
	countries.show_states(all_countries);
});