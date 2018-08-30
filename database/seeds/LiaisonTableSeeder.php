<?php

use Illuminate\Database\Seeder;

class LiaisonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
            'region_id' => 4,
            'liaison_id' => 974
        ]);
    }
}
