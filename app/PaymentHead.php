<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHead extends Model
{
    protected $fillable = ['membership_period_id' ,'currency_id' ,'service_tax_class_id' ,'amount'];

    public function scopeGetHead($query, $period, $currency_id){
    	$condition = ['membership_period_id' => $period, 'currency_id' => $currency_id];
    	return $query->where($condition);
    }

    public function membershipPeriod() {
        return $this->hasOne('App\MembershipPeriod', 'id', 'membership_period_id');
    }
}

