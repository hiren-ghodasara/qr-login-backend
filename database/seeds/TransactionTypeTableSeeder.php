<?php

use Illuminate\Database\Seeder;

class TransactionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions_type')->insert([
            'name' => 'add stripe payments',
            'description' => 'add money from stripe',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        DB::table('transactions_type')->insert([
            'name' => 'join contest',
            'description' => 'pay money for join contest',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
