<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['payment_id', 'narration_id', 'paid_amount'];

    public function scopeFilterByPayment($query, $id){
        $query->where('payment_id', $id);
    }

    public function narrations() {
    	return $this->hasMany('App\Narration', 'id', 'narration_id');
    }

    public function payment() {
        return $this->hasOne('App\Payment', 'id', 'payment_id');
    }

}
