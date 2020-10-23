<?php

namespace App\Http\Controllers;

use App\Orm\Organization;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function show(Organization $organization)
    {
        $seoMeta = [
            'description' => Str::limit($organization->description, 140),
            'keywords' => $organization->name,
        ];

        return view('frontpage', [
            'seo' => $seoMeta,
            'title' => config('app.name') . '|' . $organization->name
        ]);
    }
}
