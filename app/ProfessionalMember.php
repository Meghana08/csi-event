<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfessionalMember extends Model
{
    protected $fillable = ['id', 'organisation', 'designation']; 

    public function setAssociatingInstitutionIdAttribute($associating_institution_id){
        $this->attributes['associating_institution_id'] = (is_integer($associating_institution_id)) ? $associating_institution_id : null;
    }

    public function scopeHasAssociatingInstitution($query) {
    	return ($query->whereNotNull('associating_institution_id')->first() == null)? false: true;
    }

    public function institution() {
        return $this->hasOne('App\Institution', 'id', 'associating_institution_id');
    }

}
