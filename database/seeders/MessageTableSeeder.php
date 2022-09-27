<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pcm_dms_messages')->truncate();
        $path = public_path('sql/pcm_dms_messages.sql');
        $sql = file_get_contents($path);
        DB::insert($sql);
    }
}
