<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailNotaProduk extends Model
{
    protected $table = 'detail_nota_produk';
    protected $guarded = ['id'];

    public function produk()
    {
        return $this->belongsTo('App\Produk', 'id_produk', 'id')->select('id', 'nama');
    }
}
