<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class Status extends Model {
	    protected $table = 'status';

	    protected $fillable = ['status'];

	    // PARENT TO (states) 
	    public function users()
		{
		    return $this->hasMany('\Models\User');
		}

		public function packages()
		{
		    return $this->hasMany('\Models\Package');
		}

		public function bids()
		{
		    return $this->hasMany('\Models\Bid');
		}
	}
?>