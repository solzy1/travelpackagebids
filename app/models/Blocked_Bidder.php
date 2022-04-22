<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class Blocked_Bidder extends Model {
	    protected $table = 'blocked_bidders';

	    protected $fillable = ['blocked_user_id', 'package_id'];

	    // PARENT TO (states) 
		public function blocked_user()
		{
		    return $this->belongsTo('\Models\Blocked_User');
		}

		public function package()
		{
		    return $this->belongsTo('\Models\Package');
		}
	}
?>