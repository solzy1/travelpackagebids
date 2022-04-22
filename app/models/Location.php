<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class Location extends Model {
	    protected $table = 'locations';

	    protected $fillable = ['user_id', 'country_id', 'state_id'];
       
	    // CHILD TO (countries) 
	    public function country()
		{
		    return $this->belongsTo('\Models\Country');
		}

		public function state()
		{
		    return $this->belongsTo('\Models\State');
		}

		public function user()
		{
		    return $this->belongsTo('\Models\User');
		}
	}
?>