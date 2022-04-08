<?php
	namespace Controllers;

	use Models\Comment;
	
	// CRUD (CREATE, READ, UPDATE, DELETE)
	class Comments{
		// CREATE
	    public static function create($package_id, $user_id, $comment){
	    	$created = Comment::firstOrCreate(['package_id' => $package_id, 'user_id' => $user_id, 'comment' => $comment]);

	    	return $created;
	    }

	    // READ
		public static function index(){
	        $get = Comment::all();

	        return $get;
	    }

	    public static function find($comment_id){
	        $get = Comment::find($comment_id);

	        return $get;
	    }

	    public static function find_bypackage($package_id){
	        $get = Comment::where('package_id', $package_id)->get();

	        return $get;
	    }

	    // UPDATE
	    public static function update($id, $package_id, $user_id, $comment){
	        $_update = Comment::find($id);

	        $_update->package_id = $package_id;
	        $_update->user_id = $user_id;
	        $_update->comment = $comment;
	        
	        return $_update->save();
	    }

	    // DELETE
	    public static function destroy($id)
	    {
	        $_destroy = Comment::find($id);

	        return $_destroy->delete();
	    }
	}
?>