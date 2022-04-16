<?php
	namespace Controllers;

	use Models\Package;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Packages{
		// CREATE
	    public static function create($user_id, $state_id, $people, $from_date, $to_date, $description, $status_id){
	    	$created = Package::firstOrCreate(['user_id' => $user_id, 'state_id' => $state_id, 'people' => $people, 'from_date' => $from_date, 'to_date' => $to_date, 'description' => $description, 'status_id' => $status_id]);

	    	return $created;
	    }

	    // READ
		public static function index($search = []){
	        $value = isset($search['value']) ? $search['value'] : '';
	        $filter = isset($search['filter']) ? $search['filter'] : '';

	        $packages = Package::where('description', 'like', '%'.(!empty($filter) ? '' : $value).'%'); // if filter is not empty, return all packages, else

	        if($filter=="Country"){
	        	$packages = $packages->join('States', 'States.id', 'Packages.state_id')->join('Countries', 'Countries.id', 'States.country_id')->where('Countries.name', 'like', '%'.$value.'%');
	        }
	        if($filter=="State"){
	        	$packages = $packages->join('States', 'States.id', 'Packages.state_id')->where('States.name', 'like', '%'.$value.'%');
	        }
	        if($filter=="People"){
	        	$packages = $packages->where('people', 'like', '%'.$value);
	        }

	        return $packages->select('Packages.*')->get();
	    }

		public static function index_orderbydate($order){
	        $get = Package::join('Status', 'Status.id', 'Packages.status_id')->where('Status.status', 'active')->select('Packages.*')->orderBy('created_at', $order)->get(); 
	        // join('Status', 'Status.id', 'Packages.status_id')->where('Status.status', 'active')->
	        // ->select('Packages.*')

	        return $get;
	    }

	    public static function find($package_id){
	        $get = Package::find($package_id);

	        return $get;
	    }

	    public static function find_byuser($user_id){
	        $get = Package::where('user_id', $user_id)->join('Status', 'Status.id', 'Packages.status_id')->where('Status.status', 'active')->select('Packages.*')->get();

	        return $get;
	    }

	    public static function find_bypackage($package_id, $state_id){
	        $get = Package::where('package_id', $package_id)->where('state_id', $state_id)->join('Status', 'Status.id', 'Packages.status_id')->where('Status.status', 'active')->select('Packages.*')->first();

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
	        $_update->status_id = $status_id;
	        
	        return $_update->save();
	    }

	    public static function update_status($id, $status_id){
	    	if(is_array($id))
	    		$_update = Package::whereIn('id', $id);
	    	else
	        	$_update = Package::find($id);

	        return $_update->update(['status_id' => $status_id]);
	    }

	    // DELETE
	    public static function destroy($id)
	    {	
	    	if(is_array($id)){
	    		$_destroy = Package::whereIn('id', $id);
	    	}
	        else{
	        	$_destroy = Package::find($id);
	        }

	        return $_destroy->delete();
	    }
	}
?>