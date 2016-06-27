<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsiIndividualSubscriber extends Model
{
    //
    protected $fillable =['no_of_candidates','file'];
    
	public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }

    public function memberId(){
    	return $this->hasOne('App\Member', 'id', 'member_id');
    }
}
