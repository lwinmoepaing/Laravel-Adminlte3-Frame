<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientAppointmentRequest extends FormRequest
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
            'title' => 'required',
            'visitors.*' => 'required',
            'visitors.*.name' => 'required|string',
            'visitors.*.phone' => 'required|string',
            'visitors.*.company_name' => 'required|string',
            'visitors.*.email' => 'required|string',
            'date' => 'required',
            'time' => 'required',
            'branch' => 'required',
            'department' => 'required',
            'staff_name' => 'required',
            'staff_email' => 'required',
        ];
    }
}
