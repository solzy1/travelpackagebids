<?php
	namespace Controllers;

	use Models\User;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Users{
		// CREATE
	    public static function create($email, $userrole_id, $status_id){
	    	$created = User::firstOrCreate(['email' => $email, 'userrole_id' => $userrole_id, 'status_id' => $status_id]);

	    	return $created;
	    }

	    // READ
		public static function index($search = []){
	        $value = isset($search['value']) ? $search['value'] : '';
	        $filter = isset($search['filter']) ? $search['filter'] : '';

	        $users = User::where('email', 'like', '%'.(!empty($filter) ? '' : $value).'%'); // if filter is not empty, return all users, else

	        $location = $filter=="Country" || $filter=="State";

	        if($filter!="" && !$location){
	        	$users = $users->join('profiles', 'profiles.user_id', 'users.id');
	        }
	        if($location){
	        	$users = $users->join('locations', 'locations.user_id', 'users.id');
	        }

	        if($filter=="Name" || $filter=="Allowed to bid" || $filter=="Barred from bidding"){
	        	$users = $users->where('profiles.name', 'like', '%'.$value.'%');

	        	if($filter!='Name'){
	        		$users = $users->orWhere('email', 'like', '%'.$value.'%');
	        	}
	        }
	        else if($filter=="Country"){
	        	$users = $users->join('countries', 'countries.id', 'locations.country_id')->where('countries.name', 'like', '%'.$value.'%');
	        }
	        else if($filter=="State"){
	        	$users = $users->join('states', 'states.id', 'locations.state_id')->where('states.name', 'like', '%'.$value.'%');
	        }
	        else if($filter=="Phone number"){
	        	$users = $users->join('countries', 'countries.id', 'profiles.country_id')->where('countries.phone_code', 'like', '%'.$value)->orWhere('profiles.phone', 'like', $value.'%');
	        }    
	        
	        // rightJoin('userroles', 'userroles.id', 'users.userrole_id')->where('userroles.name', '!=', 'admin')->

	        return $users->select('users.*')->distinct()->get();
	    }

	    public static function find($user_id){
	    	return Users::find_byuser($user_id);
	    }

	    public static function find_byemail($email){
	    	$found = User::where('email', 'like', $email)->first();

	        return $found;
	    }

	    public static function find_byuser($user_id){ 
	        $user = User::find($user_id);

	        return $user;
	    }

	    // UPDATE
	    public static function update($id, $email, $password, $status_id){
	        $_update = User::find($id);

	        $_update->email = $email;
	        $_update->password = $password;
	        $_update->status_id = $status_id;
	        
	        return $_update->save();
	    }
	    
	    public static function update_status($id, $status_id){
	    	if(is_array($id))
	    		$_update = User::whereIn('id', $id);
	    	else
	        	$_update = User::find($id);

	        return $_update->update(['status_id' => $status_id]);
	    }

	    public static function update_isverified($id, $is_verified){
	        $_update = User::find($id);

	        $_update->is_verified = $is_verified;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = User::join('userroles', 'userroles.id', 'users.userrole_id')->where('userroles.name', '!=', 'admin');

	        if(is_array($id)){
	    		$_destroy = $_destroy->whereIn('users.id', $id);
	        }
	        else{
		        $_destroy = $_destroy->where('users.id', $id);
		    }

	        return $_destroy->delete();
	    }
	}
?>