<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DemoUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i <= 25; $i++) {
            $sourceDir = storage_path('app/public/avatars_default');
            $targetDir = storage_path('app/public/avatars');
            $path = $faker->file($sourceDir, $targetDir, false);
            $user = \App\Models\Auth\User::create([
                'first_name' => "User_{$i}",
                'last_name' => 'Demo',
                'email' => "demo{$i}@user.com",
                'avatar_location' => "avatars/{$path}",
                'password' => '123456',
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
            ]);
            $user->assignRole(config('access.users.default_role'));
        }
    }
}
