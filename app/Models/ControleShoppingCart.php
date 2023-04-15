<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleShoppingCart extends Model
{
    protected $table = 'shopping_cart';

    protected $fillable = [
                            'id', 
                            'id_user',
                            'qtd',
                            'partial_value',
                            'amount_discount',
                            'amount'
                          ];

    public function rules()
    {
        return [
            'id_user'  => 'required:shopping_cart',
            'qtd'  => 'required:shopping_cart',
            'partial_value'  => 'required:shopping_cart',
            'amount_discount' => 'required:shopping_cart',
            'amount' => 'required:shopping_cart'
        ];
    }

    public function relUser() {
        return $this->hasOne('App\User', 'id', 'id_user' );
    }

    public function relProducts() {
        return $this->hasMany('App\Models\ControleProductBrazilian', 'id_shopping_cart', 'id' );
    }

    public function relProductsEuropean() {
        return $this->hasMany('App\Models\ControleProductEuropean', 'id_shopping_cart', 'id' );
    }
}
