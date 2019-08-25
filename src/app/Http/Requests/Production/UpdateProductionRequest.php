<?php

namespace App\Http\Requests\Production;

use App\Orm\Tag;
use App\Rules\Base64HeaderImage;
use App\Rules\ContainsMyOrganization;
use App\Rules\TagExists;

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
            'description' => 'max:5000|nullable',
            'organizations' => ['required', 'array', 'exists:organizations,uid', new ContainsMyOrganization],
            'tags' => ['nullable', 'array', new TagExists(Tag::TYPE_PRODUCTION)],
            'images.header.content' => ['nullable', new Base64HeaderImage]
        ];
    }
}
