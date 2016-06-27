<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsiOrganisationSubscriber extends Model
{
    //
    protected $fillable =['event_id','member_id','no_of_candidates'];
    
    public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }

    public function memberId(){
    	return $this->hasOne('App\Member', 'id', 'member_id');
    }
}
