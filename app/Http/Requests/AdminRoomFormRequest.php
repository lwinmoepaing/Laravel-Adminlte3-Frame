<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRoomFormRequest extends FormRequest
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
            'room_name' => 'required',
            'branch_id' => 'required',
            'note' => 'string|nullable',
            'seat_count' => 'integer|nullable',
            'area' => 'string|nullable',
        ];
    }
}
