<?php
	namespace Controllers;

	use Models\UserConfirmation;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class UserConfirmations{
		// CREATE
	    public static function create($user_id, $confirmuser){
	    	$created = UserConfirmation::firstOrCreate(['user_id' => $user_id, 'confirmuser' => $confirmuser]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = UserConfirmation::all();

	        return $get;
	    }

	    public static function find_bykey($key){
	    	$found = UserConfirmation::where('confirmuser', '=', $key)->first();

	        return $found;
	    }

	    public static function find_byuser($user_id){
	        $admin = UserConfirmation::find($user_id);

	        return $admin;
	    }

	    // UPDATE
	    public static function update($id, $user_id, $confirmuser){
	        $_update = UserConfirmation::find($id);

	        $_update->user_id = $user_id;
	        $_update->confirmuser = $confirmuser;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = UserConfirmation::find($id);

	        return $_destroy->delete();
	    }
	}
?>