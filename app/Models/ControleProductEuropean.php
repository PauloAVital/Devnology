<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProductEuropean extends Model
{
    protected $table = 'products_european';

    protected $fillable = [
                            'id',
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
            'name'  => 'required:products_european',
            'price' => 'required:products_european',
            'hasDiscount' => 'required:products_european'
        ];
    }

    public function relShoppingCart() {
        return $this->hasOne('App\Models\ControleShoppingCart', 'id', 'id_shopping_cart' );
    }
}
