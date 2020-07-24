<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('managers')->insert([
            'user_name' => 'admin',
            'password' => Hash::make('password'),
            'full_name' => 'Admin Manager',
            'email' => 'admin@gmail.com',
            'phone' => '0965342134',
            'role' => '1',
            
        ]);

        DB::table('managers')->insert([
            'user_name' => 'seller1',
            'password' => Hash::make('password'),
            'full_name' => 'Seller 1',
            'email' => 'seller1@gmail.com',
            'phone' => '0954735468',
            'role' => '0',
            
        ]);

        DB::table('managers')->insert([
            'user_name' => 'seller2',
            'password' => Hash::make('password'),
            'full_name' => 'Seller 2',
            'email' => 'seller2@gmail.com',
            'phone' => '0954735468',
            
        ]);
    }
}
