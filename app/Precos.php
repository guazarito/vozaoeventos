<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Precos extends Model
{
    protected $fillable = [
        'tipo', 'lote', 'preco'
    ];
}
