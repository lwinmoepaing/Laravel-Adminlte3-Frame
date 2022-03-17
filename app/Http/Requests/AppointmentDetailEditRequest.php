<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentDetailEditRequest extends FormRequest
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
            'visitors.*.type' => 'required|string',
            'visitors.*.id' => 'required|string',
            'visitors.*.status' => 'required|string',
            'date' => 'required',
            'time' => 'required',
        ];
    }
}
