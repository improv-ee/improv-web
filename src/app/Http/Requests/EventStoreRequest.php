<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
        return[
            'times.start' => 'required|date',
            'times.end' => 'required|date|after:times.start',
            'title'=>'max:255|nullable',
            'description'=>'max:3000|nullable'
        ];
    }
}
