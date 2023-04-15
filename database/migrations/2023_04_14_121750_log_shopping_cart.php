<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogShoppingCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOG_shopping_cart', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('id_user_function');
            $table->string('function', 50);
            $table->integer('id_user');
            $table->integer('qtd');
            $table->decimal('partial_value', 5, 2);
            $table->decimal('amount_discount', 5, 2);
            $table->decimal('amount', 5, 2);
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
        Schema::dropIfExists('LOG_shopping_cart');
    }
}
