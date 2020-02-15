<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'days' => 'required|array',
            'days.*' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'days.required' => 'Please select days of week.',
        ];
    }
}
