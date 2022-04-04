<?php
	namespace Models;
	 
	use Illuminate\Database\Eloquent\Model;
	 
	class Reply extends Model {
	    protected $table = 'replies';

	    protected $fillable = ['comment_id', 'reply_id'];
        
	    // CHILD OF (user, state [many to one])
	    public function comment()
		{
		    return $this->belongsTo('\Models\Comment');
		}
	}
?>