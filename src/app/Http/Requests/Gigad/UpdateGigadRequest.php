<?php

namespace App\Http\Requests\Gigad;

use App\Rules\Base64HeaderImage;
use App\Rules\ContainsMyOrganization;

class UpdateGigadRequest extends DeleteGigadRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'link' => 'max:255|nullable|min:5|url',
            'description' => 'max:500|nullable',
            'organization_uid' => ['required', 'exists:organizations,uid', new ContainsMyOrganization],
            'images.header.content' => ['nullable', new Base64HeaderImage],
            'is_public' => 'required|bool',
            'gig_category_id' => ['required', 'int', 'exists:gig_categories,id']
        ];
    }
}
