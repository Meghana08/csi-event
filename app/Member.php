<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Kbwebs\MultiAuth\PasswordResets\CanResetPassword;
use Kbwebs\MultiAuth\PasswordResets\Contracts\CanResetPassword as CanResetPasswordContract;

class Member extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{


     /**
     * The database table used by the model.
     *
     * @var string
     */

	use Authenticatable, Authorizable, CanResetPassword;
	

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['membership_id', 'csi_chapter_id', 'email', 'email_extra', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function membership() {
        return $this->hasOne('App\Membership', 'id', 'membership_id');
    }


    public function scopeGetAllInstitions($query) {
        return $query->where('membership_id', 1);
    }

    /**
     * @return [Institution/Individual] [get sub-type membership]
     */
    public function getMembership() {
        if($this->membership->type == 'individual') {
            return $this->hasOne('App\Individual', 'member_id', 'id');
        } elseif ($this->membership->type == 'institutional') {
            return $this->hasOne('App\Institution', 'member_id', 'id');
        }
    }

    public function setEmailExtraAttribute($email_extra){
        $this->attributes['email_extra'] = trim($email_extra) !== '' ? $email_extra : null;
    }

    public function chapter() {
        return $this->hasOne('App\CsiChapter', 'id', 'csi_chapter_id');
    }

    public function addresses() {
        return $this->hasMany('App\Address', 'member_id', 'id');
    }

    public function phones() {
        return $this->hasMany('App\Phone', 'member_id', 'id');
    }

    public function payments() {
        return $this->hasMany('App\Payment', 'paid_for', 'id');
    }

    public function requests() {
        return $this->hasMany('App\Request', 'requested_by', 'id');
    }

}
