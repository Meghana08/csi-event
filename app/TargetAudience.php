<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TargetAudience extends Model
{
   public $table="target_audience";
   protected $fillable = ['target_name'];
}
