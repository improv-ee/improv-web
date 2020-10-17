<?php

return [

    /**
     * List of Places filters to apply to the Place auto-complete selector
     *
     * See "Optional parameters" -> components at https://developers.google.com/places/web-service/autocomplete
     */
    'allowed_places' => 'country:ee',

    // Event\production\organization header images
    // Ref \App\Rules\Base64HeaderImage
    'images' => [
        'header' => [

            // min & max - strict form validation rules; images outside of these bounds fail to upload
            // optimal - best size for image; uploaded image will be converted to this size
            // see https://spatie.be/docs/image/v1/image-manipulations/resizing-images#width-and-height#fit
            'width' => [
                'min' => 900,
                'max' => 4000,
                'optimal' => 1920
            ],
            'height' => [
                'min' => 300,
                'max' => 3000,
                'optimal' => 1005
            ]
        ]
    ]
];
