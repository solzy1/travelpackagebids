<?php
	namespace Controllers;

	use Models\Userrole;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Userroles{
		// CREATE
	    public static function create($name){
	    	$created = Userrole::create(['name' => $name]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Userrole::all();

	        return $get;
	    }

	    public static function find($id){
	    	$found = Userrole::find($id);

	    	return $found;
	    }

		public static function find_byrole($role){
	    	$found = Userrole::where('name', 'like', $role)->first();

	    	return $found;
	    }	    

	    // UPDATE
	    public static function update($id, $name){
	        $_update = Userrole::find($id);

	        $_update->name = $name;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Userrole::find($id);

	        return $_destroy->delete();
	    }
	}
?>