<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetAudienceWithFee extends Model
{
	//public $table="target_audience_with_fees";
    protected $fillable =['event_id','target_id','fee'];

	public function feeEvent() {
        return $this->hasOne('App\Event', 'id', 'event_id');
    }

    public function feeTarget(){
    	return $this->hasOne('App\TargetAudience','id','target_id');
    }

}