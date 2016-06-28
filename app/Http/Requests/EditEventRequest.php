<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditEventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_name'=>'required|string',
            'event_type_id'=>'required',
            'event_theme'=>'required',
            'event_start_date'=>'required|date_format:Y-m-d',
            'event_end_date'=>'required|date_format:Y-m-d',
            'event_start_time'=>'required',
            'event_end_time'=>'required',
            'event_venue'=>'required|string',
            'event_description'=>'required|string',
            'payment_option'=>'required',
            'payment_deadline_date'=>'date_format:d/m/Y',
            'csi_prof_fee'=>'numeric',
            'csi_stud_fee'=>'numeric',
            'non_csi_fee'=>'numeric',
            'max_seats'=>'required|numeric',
            'registration_start_date'=>'required|date_format:Y-m-d',
            'registration_end_date'=>'required|date_format:Y-m-d',
            'registration_start_time'=> 'required',
            'registration_end_time'=> 'required',
            'certification_option'=> 'required',
            'meals_option'=> 'required',
        ];
    }
}
