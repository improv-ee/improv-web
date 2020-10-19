<?php

namespace App\Http\Requests\Gigad;

class StoreGigadRequest extends UpdateGigadRequest
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
}
