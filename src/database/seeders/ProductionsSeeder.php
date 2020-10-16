<?php
namespace Database\Seeders;

use App\Orm\Event;
use App\Orm\Production;
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


        for ($i = 0; $i < 2; $i++) {
            $production = factory(Production::class)->create();

            $event = factory(Event::class, rand(1, 4))->create(['production_id' => $production->id]);
        }
    }

}
