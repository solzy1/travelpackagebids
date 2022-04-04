<?php
	namespace Models;
	 
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\SoftDeletes;
	 
	class Package extends Model {
		use SoftDeletes;
	     
	    protected $table = 'packages';

	    protected $fillable = ['user_id', 'state_id', 'people', 'from_date', 'to_date', 'description'];
        
        // PARENT TO (userconfirmation) 
	    public function bids()
		{
		    return $this->hasMany('\Models\Bid');
		}
		
		public function comments()
		{
		    return $this->hasMany('\Models\Package');
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
	}
?>