<?php
	namespace Models;
	 
	use Illuminate\Database\Eloquent\Model;
	 
	class UserConfirmation extends Model {
	    protected $table = 'userconfirmation';

	    protected $fillable = ['user_id', 'confirmuser'];

	    // CHILD OF (userrole [many to one])
	    public function user()
		{
		    return $this->belongsTo('\Models\User');
		}
	}
?>