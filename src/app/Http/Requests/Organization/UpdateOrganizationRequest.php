<?php

namespace App\Http\Requests\Organization;

use App\Rules\Base64HeaderImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @property \App\Orm\Organization $organization
 */
class UpdateOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only organization members with ROLE_ADMIN can edit the organization details
        return $this->organization->isAdmin(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'filled', 'max:255', 'min:2',
                Rule::unique('organization_translations', 'name')
                    ->whereNot('organization_id', $this->organization->id)
            ],
            'description' => 'max:3000',
            'is_public' => 'boolean',
            'images.header.content' => ['nullable', new Base64HeaderImage]
        ];
    }
}
