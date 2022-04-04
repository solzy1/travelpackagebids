<?php
	namespace Models;
	 
	use \Illuminate\Database\Eloquent\Model;
	 
	class Userrole extends Model {
	    protected $table = 'userroles';

	    protected $fillable = ['name'];

	    // PARENT TO (user [one to many]) 
	    public function users()
		{
		    return $this->hasMany('\Models\User');
		}
	}
?>