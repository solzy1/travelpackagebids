<?php
	namespace Models;
	 
	use Illuminate\Database\Eloquent\Model;
	 
	class Bid extends Model {
	    protected $table = 'bids';

	    protected $fillable = ['package_id', 'bidder_id', 'offer', 'status_id', 'deadline'];
        
	    // CHILD OF (user, state [many to one])
	    public function user()
		{
		    return $this->belongsTo('\Models\User');
		}
		
		public function package()
		{
		    return $this->belongsTo('\Models\Package');
		}

		public function status()
		{
		    return $this->belongsTo('\Models\Status');
		}
	}
?>