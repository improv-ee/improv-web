<?php

namespace Database\Seeders;

use App\Orm\GigCategory;
use Illuminate\Database\Seeder;

class GigCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Add initial data
        $categories = [
            [
                'name' => 'Tellimusetendused',
                'description' => '',
                'order' => 10
            ],[
                'name' => 'Töötoad',
                'description' => '',
                'order' => 20
            ],[
                'name' => 'Õhtujuhtimine',
                'description' => '',
                'order'=>30
            ],[
                'name' => 'Meeskonnatöö',
                'description' => '',
                'order'=> 40
            ],[
                'name' => 'Impronäitleja',
                'description' => '',
                'order'=> 50
            ],
        ];

        foreach ($categories as $input) {
            $category = new GigCategory;
            $category->save();

            $category->name = $input['name'];
            $category->description = $input['description'];
            $category->order = $input['order'];
            $category->save();
        }
    }
}
