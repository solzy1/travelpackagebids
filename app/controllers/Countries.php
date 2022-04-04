<?php
	namespace Controllers;

	use Models\Country;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Countries{
		// CREATE
	    public static function create($name){
	    	$created = Country::create(['name' => $name]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Country::all();

	        return $get;
	    }

	    public static function find($id){
	    	$found = Country::find($id);

	    	return $found;
	    }

		public static function find_bycountry($country){
	    	$found = Country::where('name', 'like', $country)->first();

	    	return $found;
	    }	    

	    // UPDATE
	    public static function update($id, $name){
	        $_update = Country::find($id);

	        $_update->name = $name;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Country::find($id);

	        return $_destroy->delete();
	    }
	}
?>