<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsiRegion extends Model
{
	protected $fillable = ['country_code', 'name'];

	public function state(){
        return $this->hasOne('App\Country', 'alpha3_code', 'country_code');
    }
}
