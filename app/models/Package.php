<?php
	namespace Models;
	 
	use Illuminate\Database\Eloquent\Model;
	 
	class Package extends Model {
	    protected $table = 'packages';

	    protected $fillable = ['user_id', 'state_id', 'people', 'from_date', 'to_date', 'description', 'status_id'];
        
        // PARENT TO (userconfirmation) 
	    public function bids()
		{
		    return $this->hasMany('\Models\Bid');
		}
		
		public function comments()
		{
		    return $this->hasMany('\Models\Comment');
		}
		
		public function blocked_bidders()
		{
		    return $this->hasMany('\Models\Blocked_Bidder');
		}

	    // CHILD OF (user, state [many to one])
	    public function user()
		{
		    return $this->belongsTo('\Models\User');
		}
		
		public function state()
		{
		    return $this->belongsTo('\Models\State');
		}

		public function status()
		{
		    return $this->belongsTo('\Models\Status');
		}
	}
?>