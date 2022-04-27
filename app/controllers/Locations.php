<?php
	namespace Controllers;

	use Models\Location;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Locations{
		// CREATE
	    public static function create($user_id, $country_id, $state_id){
	    	$created = Location::create(['user_id' => $user_id, 'country_id' => $country_id, 'state_id' => $state_id]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Location::all();

	        return $get;
	    }

	    public static function find($id){
	    	$found = Location::find($id);

	    	return $found;
	    }
        
	    public static function find_bycountry($country_id, $user_id){
	    	$get = Location::where('country_id', $country_id)->where('user_id', '!=', $user_id)->groupBy('user_id')->select('locations.*');

	    	return $get->get();
	    }

	    public static function agentlocation_exists($user_id, $country_id, $state_id){
	    	$found = Location::where('user_id', $user_id)->where('country_id', $country_id)->where('state_id', $state_id)->first();

	    	return $found;
	    }

	    public static function find_byuser($user_id){
	    	$get = Location::where('user_id', $user_id)->groupBy('country_id')->join('countries', 'countries.id', 'locations.country_id')->orderBy('countries.name', 'asc')->select('locations.*');

	    	return $get->get();
	    }

	    public static function find_bystates($user_id, $country_id = 0){
	    	$get = Location::where('user_id', $user_id)->where('state_id', '>', 0);

	    	if($country_id){
	    		$get = $get->where('locations.country_id', $country_id)->join('states', 'states.id', 'locations.state_id')->orderBy('states.name', 'asc')->select('locations.*');
	    	}

	    	return $get->get();
	    }

	    // UPDATE
	    public static function update($id, $user_id, $state_id){
	        $_update = Location::find($id);

	        $_update->user_id = $user_id;
	        $_update->state_id = $state_id;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Location::find($id);

	        return $_destroy->delete();
	    }

	    public static function destroy_country($user_id, $country_id)
	    {
	        $_destroy = Location::where('user_id', $user_id)->where('country_id', $country_id);

	        return $_destroy->delete();
	    }
	}
?>