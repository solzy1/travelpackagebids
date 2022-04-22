<?php
	namespace Controllers;

	use Models\Userconfirmation;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Userconfirmations{
		// CREATE
	    public static function create($user_id, $confirmuser){
	    	$created = Userconfirmation::firstOrCreate(['user_id' => $user_id, 'confirmuser' => $confirmuser]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Userconfirmation::all();

	        return $get;
	    }

	    public static function find_bykey($key){
	    	$found = Userconfirmation::where('confirmuser', '=', $key)->first();

	        return $found;
	    }

	    public static function find_byuser($user_id){
	        $admin = Userconfirmation::find($user_id);

	        return $admin;
	    }

	    // UPDATE
	    public static function update($id, $user_id, $confirmuser){
	        $_update = Userconfirmation::find($id);

	        $_update->user_id = $user_id;
	        $_update->confirmuser = $confirmuser;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Userconfirmation::find($id);

	        return $_destroy->delete();
	    }
	}
?>