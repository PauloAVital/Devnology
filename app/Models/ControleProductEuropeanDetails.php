<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProductEuropeanDetails extends Model
{
    protected $table = 'products_european_details';

    protected $fillable = [
                            'id',
                            'uuid',
                            'adjective',
                            'material'
                          ];
}
