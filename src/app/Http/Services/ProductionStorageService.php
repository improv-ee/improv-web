<?php

namespace App\Http\Services;

use App\Orm\Image;
use App\Orm\OrganizationTranslation;
use App\Orm\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionStorageService
{

    /**
     * @param Production $production
     * @param Request $request
     * @return Production
     */
    public function saveProduction(Production $production, Request $request): Production
    {
        $production->fill($request->all());

        $image = Image::where('uid', $request->post('header_img'))->first();

        if ($image) {
            $production->header_img_id = $image->id;
        }


        $organizations = OrganizationTranslation::whereIn('slug', $request->input('organizations', []))
            ->pluck('organization_id');

        DB::transaction(function () use ($production, $organizations) {
            $production->save();
            $production->organizations()->sync($organizations);
        });

        return $production;
    }

}