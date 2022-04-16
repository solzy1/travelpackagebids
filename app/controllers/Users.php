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

	        if($filter=="Email"){
	        	$users = $users->where('email', 'like', '%'.$value.'%');
	        }
	        else if($filter=="Country"){
	        	$users = $users->join('Profiles', 'Profiles.user_id', 'Users.id')->join('Countries', 'Countries.id', 'Profiles.country_id')->where('Countries.name', 'like', '%'.$value.'%');
	        }
	        else if($filter=="Name"){
	        	$users = $users->join('Profiles', 'Profiles.user_id', 'Users.id')->where('Profiles.name', 'like', '%'.$value.'%');
	        }
	        else if($filter=="Phone number"){
	        	$users = $users->join('Profiles', 'Profiles.user_id', 'Users.id')->join('Countries', 'Countries.id', 'Profiles.country_id')->where('Countries.phone_code', 'like', '%'.$value)->orWhere('Profiles.phone', 'like', $value.'%');
	        }

	        return $users->join('Userroles', 'Userroles.id', 'Users.userrole_id')->where('Userroles.name', '!=', 'admin')->select('Users.*')->get();
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
	        $_destroy = User::join('Userroles', 'Userroles.id', 'Users.userrole_id')->where('Userroles.name', '!=', 'admin');

	        if(is_array($id)){
	    		$_destroy = $_destroy->whereIn('Users.id', $id);
	        }
	        else{
		        $_destroy = $_destroy->where('Users.id', $id);
		    }

	        return $_destroy->delete();
	    }
	}
?>