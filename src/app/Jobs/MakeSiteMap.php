<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class MakeSiteMap implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Starting sitemap generation');

        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/contact'))
            ->add(Url::create('/terms'))
            ->add(Url::create('/privacy'))
            ->add(Url::create('/gigs'));

        foreach (['events', 'organizations', 'productions'] as $model) {
            // Retrieve main domain objects from the DB. They are publicly linkable. Add links to them to the sitemap
            // one by one. A DB query is used (instead of ORM object) for performance; as we only really need the uid column
            DB::table($model)
                ->select('uid')
                ->where('is_public', 1)
                ->orderBy('updated_at', 'DESC')
                ->limit(2000)
                ->pluck('uid')
                ->each(function ($uid) use ($sitemap, $model) {
                    $sitemap->add(Url::create( "/{$model}/{$uid}"));
                });
        }

        $sitemap->writeToDisk('media', 'sitemap.xml');

        Log::info('Generated new sitemap', ['entries' => count($sitemap->getTags())]);
    }
}
