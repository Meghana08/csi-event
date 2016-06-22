<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsiChapter extends Model
{
    protected $fillable = ['csi_state_code', 'name'];

    public function state(){
        return $this->hasOne('App\CsiState', 'state_code', 'csi_state_code');
    }

}
