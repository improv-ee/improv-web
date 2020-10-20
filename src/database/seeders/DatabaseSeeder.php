<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);

        $this->call(OrganizationsSeeder::class);

        $this->call(ProductionsSeeder::class);
        $this->call(GigCategorySeeder::class);
        $this->call(GigadSeeder::class);

    }
}
