<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class Comment extends Model {
	    protected $table = 'comments';

	    protected $fillable = ['package_id', 'user_id', 'comment'];
        
        // PARENT TO (replies [one to many]) 
	    public function replies()
		{
		    return $this->hasMany('\Models\Reply');
		}
		
	    // CHILD TO (user [one to many]) 
	    public function user()
		{
		    return $this->belongsTo('\Models\User');
		}
		
		public function package()
		{
		    return $this->belongsTo('\Models\Package');
		}
	}
?>