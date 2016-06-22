<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventRequestAdminDecision extends Model
{
    public $table ="event_request_admin_decisions";
    protected $fillable = ['decision'];
}
