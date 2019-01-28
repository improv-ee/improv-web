<?php

use App\Orm\Event;
use App\Orm\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Orm\Production;
use App\Orm\Organization;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ProductionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importDb =DB::connection('migration');
        $events = $importDb->table('wp_6_em_events')->select()->get();

        $organizations = [
            21 => ['name'=>'Eesti Improteater'],
            19 => ['name'=>'Jaa !mproteater'],
            22 => ['name'=>'Improteater IMPEERIUM'],
            26 => ['name'=>'Kogu Moos!'],
            20 => ['name'=>'Ruutu10'],
            1 =>  ['name'=>'Tilt'],
            28 => ['name'=>'English Improv in Tallinn'],
            23 => ['name'=>'Koosen'],
            27 => ['name'=>'Komejant'],
            25 => ['name'=>'Improssiivne'],
            2 => ['default']
        ];

        foreach ($events as $em_event) {

            $production = Production::whereTranslation('title', $em_event->event_name)->first();
            if (!$production) {

                $production = $this->createProduction($em_event, $importDb, $organizations);

            }

            $event = new Event;
            $event->production_id = $production->id;

            $tz = new DateTimeZone('Europe/Tallinn');
            $start_time = new Carbon($em_event->event_start_date.' '.$em_event->event_start_time,$tz);
            $end_time = new Carbon($em_event->event_end_date.' '.$em_event->event_end_time,$tz);

            $event->start_time = $start_time->setTimezone('UTC');
            $event->end_time = $end_time->setTimezone('UTC');

            $event->creator_id = 1;
            $event->save();
        }


    }

    /**
     * @param $em_event
     * @param $importDb
     * @param $organizations
     * @return Production
     */
    private function createProduction($em_event, $importDb, $organizations): Production
    {
        $production = new Production;
        $production->title = html_entity_decode($em_event->event_name);
        $production->slug = $em_event->event_slug ?: $em_event->event_name;
        $production->description = strip_tags(html_entity_decode($em_event->post_content));
        $production->excerpt = strip_tags(html_entity_decode($em_event->post_content));
        $production->creator_id = 1;

        $thumbnail = $importDb->table('wp_6_postmeta')
            ->where('meta_key', '_thumbnail_id')
            ->where('post_id', $em_event->post_id)
            ->first();


        if (array_key_exists($em_event->event_owner, $organizations)) {
            $orgId = Organization::whereTranslation('name', $organizations[$em_event->event_owner]['name'])->first()->id;
            switch ($orgId) {
                case 18:
                    $orgId = 2;
                    break;
            }

        } else {
            $orgId = 2;
        }

        DB::transaction(function () use ($production, $thumbnail,$orgId,$importDb) {
        $production->save();
        $production->organizations()->attach($orgId);
        if ($thumbnail) {
            $image_url = $importDb->table('wp_6_posts')
                ->where('ID', $thumbnail->meta_value)
                ->where('post_type', 'attachment')
                ->first();

            if ($image_url) {
                $this->importImage($image_url->guid, $production);
            }

        }
        });

        return $production;
    }


    /**
     * @param $imageUrl
     * @param Production $production
     * @return mixed
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    private function importImage($imageUrl,Production $production)
    {

        $uid = sha1(random_int(PHP_INT_MIN,PHP_INT_MAX).uniqid());

            $production->addMediaFromUrl($imageUrl)
                ->withCustomProperties(['type' => 'header'])
                ->setFileName($uid)
                ->toMediaCollection('images');
    }
}
