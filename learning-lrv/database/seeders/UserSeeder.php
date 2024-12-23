<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'avatar' => 'default/user-avatar.jpg',
            'username' => 'admin',
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123123'),
            'status_id' => 1,
            //'department_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'avatar' => 'default/user-avatar.jpg',
            'username' => 'gradeus',
            'name' => 'gds.gradeus',
            'email' => 'gds.gradeus@gmail.com',
            'password' => Hash::make('123123'),
            'status_id' => 1,
            //'department_id' => 2,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
