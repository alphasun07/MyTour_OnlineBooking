<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PriorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pcm_helpdeskpro_priorities')->truncate();
        $path = public_path('sql/pcm_helpdeskpro_priorities.sql');
        $sql = file_get_contents($path);
        DB::insert($sql);
    }
}
