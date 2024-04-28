<?php
	namespace Models;
	 
	use Illuminate\Database\Eloquent\Model;
	 
	class User extends Model {
	    protected $table = 'users';

	    protected $fillable = ['email', 'password', 'userrole_id', 'is_verified', 'status_id'];
        
        // PARENT TO (userconfirmation) 
	    public function userconfirmations()
		{
		    return $this->hasMany('\Models\UserConfirmation');
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
		
		public function locations()
		{
		    return $this->hasMany('\Models\Location');
		}

		public function blocked_user()
		{
		    return $this->hasOne('\Models\Blocked_User');
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

		public function status()
		{
		    return $this->belongsTo('\Models\Status');
		}
	}
?>