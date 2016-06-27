<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventGrantStatus extends Model
{
    public $table="event_grant_statuses";

    protected $fillable = ['grant_status_name'];

    
}
