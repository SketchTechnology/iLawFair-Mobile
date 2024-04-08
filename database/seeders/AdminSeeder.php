<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            
            'first_name' => 'iLawFair',
            'last_name' => 'Admin',
            'name' => 'iLawFair Admin',
            'email' => 'admin@palm.com',
            'phone_number' => '01010101010',
            'password' => Hash::make('iLawFair@2024'),
            'role' => 'admin',
            'unique_id' =>'Super2024iLawFair',

        ]);
    }

    
}
