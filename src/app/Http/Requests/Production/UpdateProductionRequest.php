<?php

namespace App\Http\Requests\Production;

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
            'organizations' => 'required|array|exists:organization_translations,slug'
        ];
    }
}
