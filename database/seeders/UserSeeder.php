<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'first_name' => 'Maya',
            'last_name' => 'Admin',
            'email' => 'mayalkdevelopers@gmail.com',
            'password' => Hash::make('12345'), // password
            'is_super_admin' => 1,
            'created_at' => date(TIMESTAMP_FORMAT),
        ]);
    }
}
