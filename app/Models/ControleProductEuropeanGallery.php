<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProductEuropeanGallery extends Model
{
    protected $table = 'products_european_gallery';

    protected $fillable = [
                            'id',
                            'uuid',
                            'url'
                          ];
}
