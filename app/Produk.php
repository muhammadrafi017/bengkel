<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $guarded = ['id'];
    protected $cast = [
        'harga_satuan' => 'float'
    ];
}
