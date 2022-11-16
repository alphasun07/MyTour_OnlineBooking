<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pcm_members')->insert([
            'country'   => 'Dat nuoc',
            'city'      => 'Thanh pho',
            'type'      => 'Loai dia diem 1: Hotel, 2: Restaurant, 3: Outside, 4: Camping side, 5: resort, 6: Homestay',
            'address'   => 'dia diem cu the',
        ]);
    }
}
