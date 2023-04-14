<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProductEuropean extends Model
{
    protected $table = 'products-european';

    protected $fillable = [
                            'id',
                            'id_shopping_cart',
                            'id_gallery',
                            'id_details',
                            'name',
                            'description',
                            'price',
                            'hasDiscount',
                            'discountValue'
                          ];

    public function rules()
    {
        return [
            'id_gallery'  => 'required:products-european',
            'id_details'  => 'required:products-european',
            'name'  => 'required:products-european',
            'price' => 'required:products-european',
            'hasDiscount' => 'required:products-european'
        ];
    }

    public function relShoppingCart() {
        return $this->hasOne('App\Models\ControleShoppingCart', 'id', 'id_shopping_cart' );
    }

    public function relGallery() {
        return $this->hasOne('App\Models\ControleProductEuropeanGallery', 'id', 'id_gallery' );
    }

    public function relDetails() {
        return $this->hasOne('App\Models\ControleProductEuropeanDetails', 'id', 'id_details' );
    }

}
