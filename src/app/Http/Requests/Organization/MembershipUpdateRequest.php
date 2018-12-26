<?php

namespace App\Http\Requests\Organization;

use App\Orm\Organization;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class MembershipUpdateRequest
 * @property Organization $organization
 * @property User $user
 */
class MembershipUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->organization->isAdmin(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return[
            'role' => 'integer|max:1|min:0',
        ];
    }
}
