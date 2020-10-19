<?php
namespace Database\Seeders;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(2)->create();

        // Test user
        // Not present in prod
        User::factory()->make([
            'username'=>'admin',
            'password'=> Hash::make('Ajutine123')
        ])->save();
    }
}
