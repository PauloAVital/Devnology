<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductBrazilian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_brazilian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_shopping_cart')->unsigned();
            $table->foreign('id_shopping_cart')->references('id')->on('shopping_cart')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nome');
            $table->text('descricao');
            $table->string('categoria', 50);
            $table->string('imagem');
            $table->decimal('preco', 5, 2);
            $table->string('material');
            $table->string('departamento');
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
        Schema::dropIfExists('products_brazilian');
    }
}
