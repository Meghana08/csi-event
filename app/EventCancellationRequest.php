<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCancellationRequest extends Model
{
    protected $fillable =['reason','decision_id'];

    public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }

    public function decisionId(){
    	return $this->hasOne('App\EventRequestAdminDecision','id','decision_id');
    }
}
