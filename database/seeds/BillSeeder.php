<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bills')->insert([
            'total_money' => '2000.00',
            'status' => NULL,
            'user_id' => '1',
            'seller_id' => '2',
            'created_at' => '2020-08-03 13:41:53',
            'updated_at' => '2020-08-03 16:39:34',

        ]);

        DB::table('bills')->insert([
            'total_money' => '2000.00',
            'status' => '1',
            'user_id' => '2',
            'seller_id' => '3',
            'created_at' => '2020-08-03 15:33:50',
            'updated_at' => '2020-08-03 15:33:50',

        ]);

        DB::table('bills')->insert([
            'total_money' => '3000.00',
            'status' => NULL,
            'user_id' => '3',
            'seller_id' => NULL,
            'created_at' => '2020-08-03 15:34:56',
            'updated_at' => '2020-08-07 02:21:40',

        ]);

        DB::table('bills')->insert([
            'total_money' => '10000.00',
            'status' => NULL,
            'user_id' => '2',
            'seller_id' => NULL,
            'created_at' => '2020-08-03 16:19:49',
            'updated_at' => '2020-08-10 10:24:20',

        ]);

        DB::table('bills')->insert([
            'total_money' => '10000.00',
            'status' => NULL,
            'user_id' => '3',
            'seller_id' => '3',
            'created_at' => '2020-08-04 16:06:27',
            'updated_at' => '2020-08-04 10:46:57',

        ]);
    }
}
