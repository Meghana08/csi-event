<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['type_id', 'member_id', 'title', 'notification'];

    public function scopeNotificationByType($query, $type){
    	return $query->where('type_id', $type);
    }

    public function member(){
        return $this->hasOne('App\Member', 'id', 'member_id');
    }

    public function notificationType(){
        return $this->hasOne('App\NotificationType', 'id', 'type_id');
    }
}
