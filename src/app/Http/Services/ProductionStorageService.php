<?php

namespace App\Http\Services;

use App\Http\Services\Traits\SavesMediaTrait;
use App\Orm\OrganizationTranslation;
use App\Orm\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionStorageService
{
    use SavesMediaTrait;

    /**
     * @param Production $production
     * @param Request $request
     * @return Production
     */
    public function save(Production $production, Request $request): Production
    {
        $production->fill($request->all());

        $organizations = OrganizationTranslation::whereIn('slug', $request->input('organizations', []))
            ->pluck('organization_id');

        DB::transaction(function () use ($production, $organizations, $request) {
            $production->save();


            $this->syncMedia($request, $production);

            $production->organizations()->sync($organizations);
        });

        return $production;
    }

}