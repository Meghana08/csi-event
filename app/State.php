<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['country_code', 'state_code', 'name', 'capital']; 

    public function country(){
        return $this->hasOne('App\Country', 'country_code');
    }

    public function scopeFilterByStateCode($query, $code){
    	return $query->where('state_code', $code);
    }
}