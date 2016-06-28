<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateNonCsiSubscriberRequest extends Request
{
    
    private $form = [
    'non_csi_subscriber_name' => 'required|string',
    'email_id' => 'required|email',
    'contact_number' => 'required|string',
    'dob' => 'required|date_format:Y-m-d',
    'working_status' => 'required|string',
    ];

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
        return $this->form;
    }
}
