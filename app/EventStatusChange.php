<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventStatusChange extends Model
{
    protected $fillable =['event_id','prev_status','cur_status','admin_id'];

    public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }

    public function prevStatus(){
    	return $this->hasOne('App\EventStatus','id','prev_status');
    }

    public function curStatus(){
    	return $this->hasOne('App\EventStatus','id','cur_status');
    }

    // public function adminID(){
    //     return $this->hasOne('App\Admin','id','admin_id');
    // }
}
