<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill__products', function (Blueprint $table) {
            $table->id();
            $table->integer('amount_licenses');

            //foreignKey
            $table->foreignId('pro_id')
                ->constrained('products')
                ->onDelete('cascade');
            $table->foreignId('bill_id')
                ->constrained('bills')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill__products');
    }
}
