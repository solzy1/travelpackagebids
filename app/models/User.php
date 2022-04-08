<?php
	namespace Models;
	 
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	 
	class User extends Model {
		use SoftDeletes;
	     
	    protected $table = 'users';

	    protected $fillable = ['email', 'password', 'userrole_id', 'is_verified'];
        
        // PARENT TO (userconfirmation) 
	    public function userconfirmations()
		{
		    return $this->hasMany('\Models\Userconfirmation');
		}
		
		public function packages()
		{
		    return $this->hasMany('\Models\Package');
		}
		
		public function bids()
		{
		    return $this->hasMany('\Models\bids');
		}
		
		public function comments()
		{
		    return $this->hasMany('\Models\Package');
		}
		
		public function profile()
		{
		    return $this->hasOne('\Models\Profile');
		}

	    // CHILD OF (userrole [many to one])
	    public function userrole()
		{
		    return $this->belongsTo('\Models\Userrole');
		}
	}
?>