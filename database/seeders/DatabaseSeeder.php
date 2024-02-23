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
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@uzosign.com',
            'mobile' => 1,
            'password' => bcrypt('@12345678'),
            'role_id' => 1,
            'is_active' =>1,
         

        ]);
    }
}
