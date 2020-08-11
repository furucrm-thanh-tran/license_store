<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Bill_ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bill__products')->insert([
            'amount_licenses' => '5',
            'pro_id' => '1',
            'bill_id' => '1',
            'created_at' => '2020-08-10 14:50:15',
            'updated_at' => '2020-08-10 14:50:15'
        ]);

        DB::table('bill__products')->insert([
            'amount_licenses' => '3',
            'pro_id' => '2',
            'bill_id' => '1',
            'created_at' => '2020-08-10 14:51:15',
            'updated_at' => '2020-08-10 14:51:15'
        ]);

        DB::table('bill__products')->insert([
            'amount_licenses' => '5',
            'pro_id' => '3',
            'bill_id' => '2',
            'created_at' => '2020-08-11 14:50:15',
            'updated_at' => '2020-08-10 14:50:15'
        ]);

        DB::table('bill__products')->insert([
            'amount_licenses' => '10',
            'pro_id' => '1',
            'bill_id' => '2',
            'created_at' => '2020-08-10 14:51:15',
            'updated_at' => '2020-08-10 14:51:15'
        ]);

        DB::table('bill__products')->insert([
            'amount_licenses' => '20',
            'pro_id' => '2',
            'bill_id' => '2',
            'created_at' => '2020-08-10 14:52:15',
            'updated_at' => '2020-08-10 14:52:15'
        ]);
    }
}
