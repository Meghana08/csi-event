<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisationSubscriberNominees extends Model
{
    protected $fillabe = ['subscriber_id','nominee_name','role','email','contact_number','dob'];


    public function getSubscriber() {
        return $this->hasOne('App\NonCsiOrganisationSubscribers', 'id', 'subscriber_id');
    }
}
