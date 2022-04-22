<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class Country extends Model {
	    protected $table = 'countries';

	    protected $fillable = ['name', 'phone_code'];

	    // PARENT TO (states) 
	    public function states()
		{
		    return $this->hasMany('\Models\State');
		}

		public function profiles()
		{
		    return $this->hasMany('\Models\Profile');
		}

		public function locations()
		{
		    return $this->hasMany('\Models\Location');
		}
	}
?>