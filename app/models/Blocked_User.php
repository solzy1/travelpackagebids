<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class Blocked_User extends Model {
	    protected $table = 'blocked_users';

	    protected $fillable = ['user_id', 'all_packages'];

	    // PARENT TO (states)
	    public function blocked_bidders()
		{
		    return $this->hasMany('\Models\Blocked_Bidder');
		}

		public function user()
		{
		    return $this->belongsTo('\Models\User');
		}
	}
?>