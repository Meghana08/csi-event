<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventStatus extends Model
{


   	public $table="event_status";

    protected $fillable = ['event_status_name'];

    
}
