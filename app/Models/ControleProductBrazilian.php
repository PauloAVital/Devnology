<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProductBrazilian extends Model
{
    protected $table = 'products-brazilian';

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
            'id_shopping_cart'  => 'required:products-brazilian',
            'nome'  => 'required:products-brazilian',
            'categoria'  => 'required:products-brazilian',
            'preco'  => 'required:products-brazilian',
            'departamento' => 'required|unique:products-brazilian'
        ];
    }

    public function relShoppingCart() {
        return $this->hasOne('App\Models\ControleShoppingCart', 'id', 'id_shopping_cart' );
    }
}
