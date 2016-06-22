<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsiState extends Model
{
    protected $fillable = ['csi_region_id', 'state_code'];

    public function region(){
        return $this->hasOne('App\CsiRegion', 'id', 'csi_region_id');
    }
}
