<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pcm_members')->insert([
            'name'              => 'Ten tour',
            'description'       => 'Mo Ta Tour co the dung HTML format',
            'places'            => 'dia diem dang "1,2,3,4,5" voi cac so la id trong bang places the hien thu tu chuyen di',
            'price_per_person'  => 'gia tren dau nguoi',
            'status'            => 'trang thai 1: Co san, 2: Khong co san',
            'max_person'        => 'so nguoi toi da trong tour',
            'thumbnail'         => 'anh dai dien cho tour, ten file',
            'images'            => 'nhu thumbnail',
            'category_id'       => 'ma category lay tu bang category int',
            'featured'          => '1: co, 2: khong',
        ]);
    }
}
