<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonCsiIndividualSubscribers extends Model
{
    
     protected $fillable =['name','email','contact_number','dob','working_status'];

	public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }
}
