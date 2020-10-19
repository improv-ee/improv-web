<?php

namespace App\Http\Requests\Gigad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteGigadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $gigadOrganizations = $this->gigad->organization()->get()->pluck('id')->toArray();
        foreach (Auth::user()->organizations()->get() as $organization) {
            if (in_array($organization->id, $gigadOrganizations)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
