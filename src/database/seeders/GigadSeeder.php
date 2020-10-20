<?php

namespace Database\Seeders;

use App\Orm\Gigad;
use App\Orm\Organization;
use Illuminate\Database\Seeder;

class GigadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $ads = Gigad::factory()->count(6)->make();
       foreach ($ads as $ad) {
           $ad->organization_id = Organization::inRandomOrder()->first()->id;
           $ad->save();
       }
    }
}
