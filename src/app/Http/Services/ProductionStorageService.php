<?php

namespace App\Http\Services;

use App\Orm\Image;
use App\Orm\OrganizationTranslation;
use App\Orm\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $organizations = OrganizationTranslation::whereIn('slug', $request->input('organizations', []))
            ->pluck('organization_id');

        DB::transaction(function () use ($production, $organizations, $request) {
            $production->save();

            $media = $request->input('images.header.content', false);

            if ($media) {
                $this->addMedia($media, $production);
            }

            if ($media === null) {
                $this->removeAllMedia($production);
            }

            $production->organizations()->sync($organizations);
        });

        return $production;
    }

    private function addMedia($base64Media, Production $production)
    {
        $production->addMediaFromBase64($base64Media)
            ->withCustomProperties(['type' => 'header'])
            ->setFileName($this->getFileName())
            ->toMediaCollection('images');
    }

    /**
     * Get a unique pseudo-random file name
     *
     * @return string
     */
    private function getFileName(): string
    {
        try {
            $seed = random_int(PHP_INT_MIN, PHP_INT_MAX) . uniqid();
        } catch (\Exception $e) {
            $seed = uniqid('', true) . '-' . time();
        }

        return sha1($seed);
    }

    /**
     * @param Production $production
     */
    private function removeAllMedia(Production $production)
    {
        foreach ($production->getMedia('images') as $media) {
            Log::info($media->id);
            $media->delete();
        }
    }
}