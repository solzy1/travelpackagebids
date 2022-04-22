<?php
	namespace Controllers;

	use Models\State;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class States{
		// CREATE
	    public static function create($country_id, $name){
	    	$created = State::firstOrCreate(['country_id' => $country_id, 'name' => $name]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = State::all();

	        return $get;
	    }

	    public static function find_bycountry($state_id){
	        $found = State::where('id', $state_id)->first()->country;

	        return $found;
	    }

	    public static function find_bystate($state){
	        $found = State::where('name', $state)->first();

	        return $found;
	    }

	    // UPDATE
	    public static function update($id, $country_id, $name){
	        $_update = State::find($id);

	        $_update->country_id = $country_id;
	        $_update->name = $name;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = State::find($id);

	        return $_destroy->delete();
	    }
	}
?>