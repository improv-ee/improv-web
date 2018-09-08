<?php

use App\Orm\Production;
use App\Orm\Organization;
use Illuminate\Database\Seeder;

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

        foreach ($events as $event) {
            $production = new Production;
            $production->title = $event->event_name;
            $production->slug = $event->event_slug || $event->event_name;
            $production->description = $event->post_content;
            $production->excerpt = strip_tags($event->post_content);

            $thumbnail = $importDb->table('wp_6_postmeta')
                ->where('meta_key','_thumbnail_id')
                ->where('post_id', $event->post_id)
                ->first();
            if ($thumbnail) {
                $image_url = $importDb->table('wp_6_posts')
                    ->where('ID', $thumbnail->meta_value)
                    ->where('post_type', 'attachment')
                    ->first();
                if($image_url) {
                    $production->header_img=$image_url->guid;
               }

            }

            if (array_key_exists($event->event_owner, $organizations)) {
                $orgId = Organization::whereTranslation('name', $organizations[$event->event_owner]['name'])->first()->id;
                switch ($orgId) {
                    case 18:
                        $orgId = 2;
                        break;
                }

            } else {
                $orgId=2;
            }

            $production->save();
            $production->organizations()->attach($orgId);

        }


    }
}
