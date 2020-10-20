<?php

namespace App\Http\Services;

use App\Http\Requests\Gigad\UpdateGigadRequest;
use App\Http\Services\Traits\SavesMediaTrait;
use App\Orm\Gigad;
use App\Orm\Organization;
use Illuminate\Support\Facades\DB;

class GigadStorageService
{
    use SavesMediaTrait;

    /**
     * @param Gigad $gigad
     * @param UpdateGigadRequest $request
     * @return Gigad
     */
    public function update(Gigad $gigad, UpdateGigadRequest $request): Gigad
    {
        $gigad->link = $request->input('link');
        $gigad->description = $request->input('description');
        $gigad->organization_id = Organization::where('uid', $request->input('organization_uid'))->first()->id;
        $gigad->gig_category_id = $request->input('gig_category_id');
        $gigad->is_public = $request->input('is_public', false);

        DB::transaction(function () use ($gigad, $request) {
            $gigad->save();

            $this->syncMedia($request, $gigad);
        });


        return $gigad;
    }
}
