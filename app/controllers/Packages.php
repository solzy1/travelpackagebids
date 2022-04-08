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

		public static function index_orderbydate($order){
	        $get = Package::orderBy('created_at', $order)->get();

	        return $get;
	    }

	    public static function find($package_id){
	        $get = Package::find($package_id);

	        return $get;
	    }

	    public static function find_byuser($user_id){
	        $get = Package::where('user_id', $user_id)->get();

	        return $get;
	    }

	    public static function find_bypackage($package_id, $state_id){
	        $get = Package::where('package_id', $package_id)->where('state_id', $state_id)->first();

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