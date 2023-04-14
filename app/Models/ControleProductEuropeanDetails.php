<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProductEuropeanDetails extends Model
{
    protected $table = 'products-european-details';

    protected $fillable = [
                            'id',
                            'adjective',
                            'material'
                          ];
}
