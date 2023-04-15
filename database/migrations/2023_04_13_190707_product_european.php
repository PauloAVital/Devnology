<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductEuropean extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_european', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_shopping_cart')->unsigned();
            $table->foreign('id_shopping_cart')->references('id')->on('shopping_cart')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('products_european');
    }
}
