<?php
	namespace Controllers;

	use Models\Package;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Packages{
		// CREATE
	    public static function create($user_id, $state_id, $people, $from_date, $to_date, $description){
	    	$created = Package::firstOrCreate(['user_id' => $user_id, 'state_id' => $state_id, 'people' => $people, 'from_date' => $from_date, 'to_date' => $to_date, 'description' => $description]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Package::all();

	        return $get;
	    }

	    // UPDATE
	    public static function update($id, $user_id, $state_id, $people, $from_date, $to_date, $description){
	        $_update = Package::find($id);

	        $_update->user_id = $user_id;
	        $_update->state_id = $state_id;
	        $_update->people = $people;
	        $_update->from_date = $from_date;
	        $_update->to_date = $to_date;
	        $_update->description = $description;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Package::find($id);

	        return $_destroy->delete();
	    }
	}
?>