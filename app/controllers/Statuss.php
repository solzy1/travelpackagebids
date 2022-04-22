<?php
	namespace Controllers;

	use Models\Status;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Statuss{
		// CREATE
	    public static function create($status){
	    	$created = Status::create(['status' => $status]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Status::all();

	        return $get;
	    }

	    public static function find($id){
	    	$found = Status::find($id);

	    	return $found;
	    }

		public static function find_bystatus($status){
	    	$found = Status::where('status', $status)->first();

	    	return $found;
	    }	    

	    // UPDATE
	    public static function update($id, $status){
	        $_update = Status::find($id);

	        $_update->status = $status;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Status::find($id);

	        return $_destroy->delete();
	    }
	}
?>