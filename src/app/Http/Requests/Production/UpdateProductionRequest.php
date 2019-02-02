<?php

namespace App\Http\Requests\Production;

use App\Rules\Base64HeaderImage;
use App\Rules\ContainsMyOrganization;

/**
 * Class UpdateProductionRequest
 * @package App\Http\Requests
 */
class UpdateProductionRequest extends DeleteProductionRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'excerpt' => 'max:300|nullable',
            'title' => 'max:255|required|min:3',
            'description' => 'max:3000|nullable',
            'organizations' => ['required', 'array', 'exists:organization_translations,slug', new ContainsMyOrganization],
            'images.header.content' => ['nullable', new Base64HeaderImage]
        ];
    }
}
