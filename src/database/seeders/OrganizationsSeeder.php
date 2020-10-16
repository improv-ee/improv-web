<?php
namespace Database\Seeders;

use App\Orm\Production;
use Illuminate\Database\Seeder;

class OrganizationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
            2=>['name' => 'Default']
        ];

        foreach ($organizations as $organization) {
            $org = new \App\Orm\Organization;
            $org->name = $organization['name'];
            $org->creator_id = 1;
            $org->save();
        }


    }
}
