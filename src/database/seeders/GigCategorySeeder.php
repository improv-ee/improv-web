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
                'name' => 'Etendused üritustele',
                'description' => 'TODO'
            ],[
                'name' => 'Töötoad',
                'description' => 'TODO'
            ],[
                'name' => 'Õhtujuhtimine',
                'description' => 'TODO'
            ],[
                'name' => 'Meeskonnatöö',
                'description' => 'TODO'
            ],[
                'name' => 'Impronäitleja',
                'description' => 'TODO'
            ],
        ];

        foreach ($categories as $input) {
            $category = new GigCategory;
            $category->save();

            $category->name = $input['name'];
            $category->description = $input['description'];
            $category->save();
        }
    }
}
