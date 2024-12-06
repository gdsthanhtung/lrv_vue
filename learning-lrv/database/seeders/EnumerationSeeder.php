<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EnumerationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('enumerations')->insert([
            'refTable' => 'common',
            'value' => 'Active',
            'created_at' => now(),
            'updated_at' => now()
        ], );

        DB::table('enumerations')->insert([
            'refTable' => 'common',
            'value' => 'Inactive',
            'created_at' => now(),
            'updated_at' => now()
        ], );
    }
}
