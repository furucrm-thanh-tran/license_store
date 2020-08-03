<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('product_key');
            $table->date('activation_date');
            $table->date('expiration_date');
            

            //foreignKey
            $table->foreignId('pro_id')
                ->constrained('products')
                ->onDelete('cascade');
            $table->foreignId('user_id')->nullable()
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('seller_id')->nullable()
                ->constrained('managers')
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
        Schema::dropIfExists('licenses');
    }
}
