<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $startDate = 'now';
        $endDate = '+1 months';

        for ($i = 1; $i <= 100; $i++) {
            $sourceDir = storage_path('app/public/contest_default');
            $targetDir = storage_path('app/public/contest_photo');
            $path = $faker->file($sourceDir, $targetDir, false);
            $startDate = \Carbon\Carbon::now();
            $endDate = $startDate->addMinute(rand(1, 1000));
            DB::table('contests')->insert([
                'name' => $faker->safeColorName,
                'photo' => "storage/contest_photo/{$path}",
                'description' => $faker->paragraph(rand(3, 30)),
                'created_by' => \App\Models\Auth\User::inRandomOrder()->first()->id,
                'type' => \App\Models\ContestType::inRandomOrder()->first()->id,
                'joining_fee' => $faker->numberBetween(10, 100),
                'max_user' => $faker->numberBetween(40, 50),
                'joined_user' => $faker->numberBetween(1, 40),
                'execution_date' => $endDate,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
