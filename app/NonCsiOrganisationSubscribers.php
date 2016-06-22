<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonCsiOrganisationSubscribers extends Model
{
    //
    protected $fillable =['name','contact_person','email_id','contact_number','no_of_candidates'];

	public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }
}
