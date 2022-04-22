<?php
	namespace Controllers;

	use Models\Blocked_User;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Blocked_Users{
		// CREATE
	    public static function create($user_id, $all_packages){
	    	$created = Blocked_User::create(['user_id' => $user_id, 'all_packages' => $all_packages]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Blocked_User::all();

	        return $get;
	    }

	    public static function find($id){
	    	$found = Blocked_User::find($id);

	    	return $found;
	    }

	    public static function find_byuser($user_id){
	    	$found = Blocked_User::where('user_id', $user_id);

	    	return $found->first();
	    }

	    // UPDATE
	    public static function update($id, $user_id, $all_packages){
	        $_update = Blocked_User::find($id);

	        $_update->user_id = $user_id;
	        $_update->all_packages = $all_packages;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Blocked_User::find($id);

	        return $_destroy->delete();
	    }
	}
?>