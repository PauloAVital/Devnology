<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleLOG_ProductBrazilian extends Model
{
    protected $table = 'LOG_products_brazilian';

    protected $fillable = [
                            'id', 
                            'id_user_function',
                            'function',
                            'id_shopping_cart',
                            'nome',
                            'descricao',
                            'categoria',
                            'imagem',
                            'preco',
                            'material',
                            'departamento'
                          ];

    public function rules()
    {
        return [
            'id_user_function'  => 'required:LOG_products_brazilian',
            'function'  => 'required:LOG_products_brazilian',
            'id_shopping_cart'  => 'required:LOG_products_brazilian',
            'nome' => 'required:LOG_products_brazilian',
            'descricao' => 'required:LOG_products_brazilian',
            'categoria' => 'required:LOG_products_brazilian',
            'imagem' => 'required:LOG_products_brazilian',
            'preco' => 'required:LOG_products_brazilian',
            'material' => 'required:LOG_products_brazilian',
            'departamento' => 'required:LOG_products_brazilian',
        ];
    }

    public function relShoppingCart() {
        return $this->hasOne('App\Models\ControleLOG_ShoppingCart', 'id', 'id_shopping_cart' );
    }
}
