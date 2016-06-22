<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [ 'type_id', 'member_id', 'country_code', 'state_code', 'address_line_1', 'city', 'pincode'];

    public function country()	{
    	return $this->hasOne('App\Country', 'alpha3_code', 'country_code');
    }


    public function member()	{
    	return $this->hasOne('App\Member', 'id', 'member_id');
    }


    public function state()	{
    	return $this->hasOne('App\State', 'state_code', 'state_code');
    }

	public function type()	{
    	return $this->hasOne('App\AddressType', 'id', 'type_id');
    }



}
