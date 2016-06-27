<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPost extends Model
{
    protected $fillable =['event_id','post_text','post_image'];

	public function eventId() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }
}
