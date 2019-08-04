<?php

namespace App\Http\Requests\Event;

use App\Orm\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property Event $event
 */
class DeleteEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $productionOrganizations = $this->event->production->organizations()->get()->pluck('id')->toArray();
        foreach (Auth::user()->organizations()->get() as $organization) {
            if (in_array($organization->id, $productionOrganizations)) {
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
