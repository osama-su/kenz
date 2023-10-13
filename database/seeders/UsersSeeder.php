<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'mobile' => '01111111111',
            'email' => 'admin@admin.com',
            'gov' => 'cairo',
            'address' => 'cairo',
            'password' => bcrypt('secret'),
            'role_id' => '1',

        ]);
    }
}
