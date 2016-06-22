<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventGrant extends Model
{
    protected $fillable =['grant_type_id','grant_description','reason'];

    public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }

	public function grantType() {
        return $this->hasOne('App\EventGrantType', 'id', 'grant_type_id');
    }
    
    public function grantStatus() {
        return $this->hasOne('App\EventGrantStatus', 'id', 'grant_status_id');
    }
}
