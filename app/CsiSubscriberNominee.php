<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsiSubscriberNominee extends Model
{
    protected $fillabe = ['subscriber_id','nominee_name','role','email','contact_number','dob'];


    public function getSubscriber() {
		return $this->hasOne('App\CsiOrganisationSubscribers', 'id', 'subscriber_id');
    }
}
