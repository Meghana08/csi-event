<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestService extends Model
{
    protected $fillable = ['service_id', 'member_id', 'payment_id'];

    public function scopeRequestsByServiceId($query, $id){
    	return $query->where('service_id', $id);
    }

    public function scopeRequestsByMemberId($query, $id){
    	return $query->where('member_id', $id);
    }

    public function member() {
        return $this->hasOne('App\Member', 'id', 'member_id');
    }

    public function service() {
        return $this->hasOne('App\Service', 'id', 'service_id');
    }

    public function payment() {
        return $this->hasOne('App\Payment', 'id', 'payment_id');
    }

}
