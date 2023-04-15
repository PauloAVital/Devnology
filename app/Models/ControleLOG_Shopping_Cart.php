<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleLOG_Shopping_Cart extends Model
{
    protected $table = 'LOG_shopping_cart';

    protected $fillable = [
                            'id', 
                            'id_user_function',
                            'function',
                            'id_user',
                            'qtd',
                            'partial_value',
                            'amount_discount',
                            'amount'
                          ];

    public function rules()
    {
        return [
            'id_user_function'  => 'required:LOG_shopping_cart',
            'function'  => 'required:LOG_shopping_cart',
            'id_user'  => 'required:LOG_shopping_cart',
            'qtd' => 'required:LOG_shopping_cart',
            'partial_value' => 'required:LOG_shopping_cart',
            'amount_discount' => 'required:LOG_shopping_cart',
            'amount' => 'required:LOG_shopping_cart',
        ];
    }
}
