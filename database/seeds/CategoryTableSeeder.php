<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'name' => Str::random(10),
            'title' => Str::random(10),
            'data'  => Str::random(20),
            'confirmed' => random_int(0, 1),
            'uuid' => Str::uuid(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
