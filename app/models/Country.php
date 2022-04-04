<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class Country extends Model {
	    protected $table = 'countries';

	    protected $fillable = ['name'];

	    // PARENT TO (states) 
	    public function states()
		{
		    return $this->hasMany('\Models\State');
		}
	}
?>