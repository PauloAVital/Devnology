<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogProductEuropean extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOG_products_european', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user_function');
            $table->string('function', 50);
            $table->integer('id_shopping_cart');
            $table->string('uuid');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 5, 2);
            $table->boolean('hasDiscount');
            $table->decimal('discountValue', 5, 2);
            $table->rememberToken();
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
        Schema::dropIfExists('LOG_products_european');
    }
}
