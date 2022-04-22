<?php
	namespace Controllers;

	use Models\Blocked_Bidder;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Blocked_Bidders{
		// CREATE
	    public static function create($blocked_user_id, $package_id){
	    	$created = Blocked_Bidder::create(['blocked_user_id' => $blocked_user_id, 'package_id' => $package_id]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Blocked_Bidder::all();

	        return $get;
	    }

	    public static function find($id){
	    	$found = Blocked_Bidder::find($id);

	    	return $found;
	    }

	    public static function find_byuser($blocked_user_id, $package_id = 0){
	    	$found = Blocked_Bidder::where('blocked_user_id', $blocked_user_id);

	    	if(is_numeric($package_id) && $package_id > 0)
	    		$found = $found->where('package_id', $package_id);

	    	return $found->first();
	    }

	    // UPDATE
	    public static function update($id, $blocked_user_id, $package_id){
	        $_update = Blocked_Bidder::find($id);

	        $_update->blocked_user_id = $blocked_user_id;
	        $_update->package_id = $package_id;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Blocked_Bidder::find($id);

	        return $_destroy->delete();
	    }
	}
?>