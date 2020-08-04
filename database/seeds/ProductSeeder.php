<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name_pro' => 'San pham 1',
            'desciption_pro' => 'Mo ta cua san pham 1',
            'icon_pro' => '',
            'price_license' => '10.00',
            'created_at' => '2020-08-02 23:56:32',
            'updated_at' => '2020-08-02 23:56:32',

        ]);

        DB::table('products')->insert([
            'name_pro' => 'San Pham 2',
            'desciption_pro' => "Mo ta cua san pham 2",
            'icon_pro' => '',
            'price_license' => '15.00',
            'created_at' => '2020-08-02 23:56:51',
            'updated_at' => '2020-08-02 23:56:51',
        ]);

        DB::table('products')->insert([
            'name_pro' => 'San Pham 3',
            'desciption_pro' => "Mo ta cua san pham 3",
            'icon_pro' => '',
            'price_license' => '10.00',
            'created_at' => '2020-08-02 23:58:51',
            'updated_at' => '2020-08-02 23:58:51',
        ]);
    }
}
