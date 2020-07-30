<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_name' => 'user1',
            'password' => Hash::make('password'),
            'full_name' => 'User 1',
            'email' => 'user1@gmail.com',
            'phone' => '0123456789'
        ]);

        DB::table('users')->insert([
            'user_name' => 'user2',
            'password' => Hash::make('password'),
            'full_name' => 'User 2',
            'email' => 'user2@gmail.com',
            'phone' => '0342564736'
        ]);

        DB::table('users')->insert([
            'user_name' => 'user3',
            'password' => Hash::make('password'),
            'full_name' => 'User 3',
            'email' => 'user3@gmail.com',
            'phone' => '0945367564'
        ]);
    }
}
