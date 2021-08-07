<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->insert([
            'type' => "bike",
            'name' => "Bike Adult",
            'price' => 10,
            'fee' => 2.8,
            'duration_hours' => 2
        ]);
        DB::table('packages')->insert([
            'type' => "bike",
            'name' => "Bike Kids",
            'price' => 7,
            'fee' => 1.5,
            'duration_hours' => 2
        ]);
        DB::table('packages')->insert([
            'type' => "cruise",
            'name' => "Liberty Cruise",
            'price' => 25,
            'fee' => 3.5,
            'duration_hours' => 3
        ]);
        DB::table('packages')->insert([
            'type' => "bus",
            'name' => "Downtown Bus",
            'price' => 46,
            'fee' => 6.3,
            'duration_hours' => 3
        ]);
        DB::table('packages')->insert([
            'type' => "bus",
            'name' => "Uptown Bus",
            'price' => 41,
            'fee' => 4.2,
            'duration_hours' => 2
        ]);
    }
}
