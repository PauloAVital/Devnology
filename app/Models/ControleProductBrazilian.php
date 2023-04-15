<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProductBrazilian extends Model
{
    protected $table = 'products_brazilian';

    protected $fillable = [
                            'id',
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
            'id_shopping_cart'  => 'required:products_brazilian',
            'nome'  => 'required:products_brazilian',
            'categoria'  => 'required:products_brazilian',
            'preco'  => 'required:products_brazilian',
            'departamento' => 'required|unique:products_brazilian'
        ];
    }

    public function relShoppingCart() {
        return $this->hasOne('App\Models\ControleShoppingCart', 'id', 'id_shopping_cart' );
    }
}
