<?php

return [
    'apiUrl' => sprintf('https://%s/v1', env('API_DOMAIN')),
    //'username' =>  \Illuminate\Support\Facades\Auth::user()->username ?? null,
    'organization' => ['roles' => [
        'ROLE_ADMIN' => 0
    ]
    ]
];