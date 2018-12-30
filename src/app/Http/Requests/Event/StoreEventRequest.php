<?php

namespace App\Http\Requests\Event;

class StoreEventRequest extends DeleteEventRequest
{
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
