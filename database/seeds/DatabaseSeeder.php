<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('liaison')->insert([
            'region_id' => 1,
            'liaison_id' => 971
        ]);
        DB::table('liaison')->insert([
            'region_id' => 2,
            'liaison_id' => 972
        ]);
        DB::table('liaison')->insert([
            'region_id' => 3,
            'liaison_id' => 973
        ]);
        DB::table('liaison')->insert([
            'region_id' => 974,
            'liaison_id' => 974
        ]);
    }
}
