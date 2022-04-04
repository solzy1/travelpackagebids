<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class State extends Model {
	    protected $table = 'states';

	    protected $fillable = ['country_id', 'name'];
        
        
        // PARENT TO (userconfirmation) 
	    public function packages()
		{
		    return $this->hasMany('\Models\Package');
		}
		
		public function thecountry()
		{
		    return $this->hasOne('\Models\Country');
		}
		
	    // CHILD TO (countries) 
	    public function country()
		{
		    return $this->belongsTo('\Models\Country');
		}
	}
?>