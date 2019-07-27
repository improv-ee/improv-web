<?php

namespace App\Http\Requests\Event;

class StoreEventRequest extends UpdateEventRequest
{
    public function authorize()
    {
        return true;
    }
}
