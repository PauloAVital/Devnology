<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProductEuropeanGallery extends Model
{
    protected $table = 'products-european-gallery';

    protected $fillable = [
                            'id',
                            'url'
                          ];
}
