<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateEventRequest extends Request
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
            'event_start_date'=>'required|date_format:d/m/Y',
            'event_end_date'=>'required|date_format:d/m/Y',
            'event_start_time'=>'required|time_format:hh:mm:ss',
            'event_end_time'=>'required',
            'event_venue'=>'required|string',
            'event_description'=>'required|string',
            'payment_option'=>'required',
            'payment_deadline_date'=>'date_format:d/m/Y',
            'csi_prof_fee'=>'numeric',
            'csi_stud_fee'=>'numeric',
            'non_csi_fee'=>'numeric',
            //'event_banner'=>'required',
            //'event_pdf'=>'required',
            'max_seats'=>'required|numeric',
            'registration_start_date'=>'required|date_format:d/m/Y',
            'registration_end_date'=>'required|date_format:d/m/Y',
            'event_start_time'=>'required',
            'event_end_time'=>'required',
           


            //'payment_deadline_time'=>
            //
        ];
    }
}
