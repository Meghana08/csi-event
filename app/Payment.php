<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['paid_for', 'payment_head_id', 'service_id'];

    public function getDateOfEffectAttribute($date_of_effect){
        return Carbon::parse($date_of_effect);
    }

    public function setDateOfEffectAttribute($date_of_effect){
        $this->attributes['date_of_effect'] = Carbon::createFromFormat('d/m/Y', $date_of_effect)->format('Y-m-d');
    }

    public function scopeFilterByPaymentHead($query, $id){
        $query->where('payment_head_id', $id);
    }

    public function scopeFilterByService($query, $id){
        $query->where('service_id', $id);
    }

    public function scopeRejected($query) {
        return $query->where('is_rejected', 1);
    }

    public function scopeVerified($query) {
        return $query->where('verified', 1);
    }

    public function scopeFilterByServiceAndMember($query, $id, $mid){
        $query->where('service_id', $id)->where('paid_for', $mid);
    }

    public function owner() {
        return $this->hasOne('App\Member', 'id', 'paid_for');
    }

    public function service() {
        return $this->hasOne('App\Service', 'id', 'service_id');
    }

    public function paymentHead() {
        return $this->hasOne('App\PaymentHead', 'id', 'payment_head_id');
    }

    public function requestService() {
        return $this->hasOne('App\RequestService', 'payment_id', 'id');
    }

}
