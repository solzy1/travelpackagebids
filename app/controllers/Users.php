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
		public static function index($filter = []){
			$status = isset($filter['status']) ? $filter['status'] : 'active';

	        $get = User::join('Status', 'Status.id', 'Users.status_id')->where('Status.status', $status)->select("Users.*");

	        return $get->get();
	    }

	    public static function find($user_id){
	    	return Users::find_byuser($user_id);
	    }

	    public static function find_byemail($email){
	    	$found = User::where('email', 'like', $email)->join('Status', 'Status.id', 'Users.status_id')->where('Status.status', 'active')->select('Users.*')->first();

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

	    public static function update_isverified($id, $is_verified){
	        $_update = User::find($id);

	        $_update->is_verified = $is_verified;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = User::find($id);

	        return $_destroy->delete();
	    }
	}
?>