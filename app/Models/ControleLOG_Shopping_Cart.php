<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleLOG_Shopping_Cart extends Model
{
    protected $table = 'LOG-shopping-cart';

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
            'id_user_function'  => 'required:LOG-shopping-cart',
            'function'  => 'required:LOG-shopping-cart',
            'id_user'  => 'required:LOG-shopping-cart',
            'qtd' => 'required:LOG-shopping-cart',
            'partial_value' => 'required:LOG-shopping-cart',
            'amount_discount' => 'required:LOG-shopping-cart',
            'amount' => 'required:LOG-shopping-cart',
        ];
    }
}
