<?php

namespace App\Http\Services;

use App\Http\Services\Traits\SavesMediaTrait;
use App\Orm\OrganizationTranslation;
use App\Orm\Production;
use App\Orm\Tag;
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

            $production->syncTags($this->getTagsList($request->input('tags', [])));

            $this->syncMedia($request, $production);

            $production->organizations()->sync($organizations);
        });

        return $production;
    }

    /**
     * @param array|null $tagSlugs
     * @return array
     */
    private function getTagsList(?array $tagSlugs) : array
    {

        $tags = [];
        foreach ($tagSlugs as $slug) {
            $tag = Tag::findFromSlug($slug, Tag::TYPE_PRODUCTION);
            $tags[] = $tag;
        }
        return $tags;
    }

}