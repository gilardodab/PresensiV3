<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_level')->insert([
            ['level_id' => 1, 'level_name' => 'Administrator'],
            ['level_id' => 2, 'level_name' => 'Operator']
        ]);
    }
}
