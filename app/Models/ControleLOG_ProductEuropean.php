<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleLOG_ProductEuropean extends Model
{
    protected $table = 'LOG_products_european';

    protected $fillable = [
                            'id', 
                            'id_user_function',
                            'function',
                            'id_shopping_cart',
                            'uuid',
                            'name',
                            'description',
                            'price',
                            'hasDiscount',
                            'discountValue'
                          ];

    public function rules()
    {
        return [
            'id_user_function'  => 'required:LOG_products_european',
            'function'  => 'required:LOG_products_european',
            'id_shopping_cart'  => 'required:LOG_products_european',
            'name' => 'required:LOG_products_european',
            'description' => 'required:LOG_products_european',
            'price' => 'required:LOG_products_european',
            'hasDiscount' => 'required:LOG_products_european',
            'discountValue' => 'required:LOG_products_european',
        ];
    }

    public function relShoppingCart() {
        return $this->hasOne('App\Models\ControleLOG_ShoppingCart', 'id', 'id_shopping_cart' );
    }
}
