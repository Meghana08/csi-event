<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTypeDetail extends Model
{
    protected $fillable = ['event_id', 'event_type_id','max_seats','registration_start_date','registration_end_date','registration_start_time','registration_end_time','certification','meals'];

	public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }
    
    public function eventType() {
        return $this->hasOne('App\EventType', 'id', 'event_type_id');
    }
}
