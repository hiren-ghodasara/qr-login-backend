<?php

use Illuminate\Database\Seeder;

class ContestTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contest_types')->insert([
            'name' => 'images',
            'description' => 'images description',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()

        ]);
        DB::table('contest_types')->insert([
            'name' => 'videos',
            'description' => 'videos description',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::table('contest_types')->insert([
            'name' => 'articles',
            'description' => 'articles  description',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
