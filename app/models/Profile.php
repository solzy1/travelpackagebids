<?php
	namespace Models;
	 
	use Illuminate\Database\Eloquent\Model;
	 
	class Profile extends Model {
	    protected $table = 'profiles';

	    protected $fillable = ['user_id', 'country_id', 'name', 'phone'];

	    // CHILD OF (user & country [many to one])
	    public function user()
		{
		    return $this->belongsTo('\Models\User');
		}

		public function country()
		{
		    return $this->belongsTo('\Models\Country');
		}
	}
?>