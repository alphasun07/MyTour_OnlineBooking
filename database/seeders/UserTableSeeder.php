<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pcm_users')->insert([
            'name'              => 'Testing User',
            'email'             => 'test@example.com',
            'email_verified_at' => null,
            'password'          => Hash::make('testing123'),
        ]);

        DB::table('pcm_members')->insert([
            'name'      => 'test',
            'login_id'  => 'admin',
            'password'  => Hash::make('admin123!@#$%^'),
        ]);

    }
}
