<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogProductBrazilian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOG_products_brazilian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user_function');
            $table->string('function', 50);
            $table->integer('id_shopping_cart');
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
        Schema::dropIfExists('LOG_products_brazilian');
    }
}
