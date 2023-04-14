<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleShoppingCart extends Model
{
    protected $table = 'shopping-cart';

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
            'id_user'  => 'required:shopping-cart',
            'qtd'  => 'required:shopping-cart',
            'partial_value'  => 'shopping-cart',
            'amount_discount' => 'shopping-cart',
            'amount' => 'shopping-cart'
        ];
    }

    public function relUser() {
        return $this->hasOne('App\User', 'id', 'id_user' );
    }

}
