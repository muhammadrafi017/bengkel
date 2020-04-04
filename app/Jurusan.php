<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $guarded = ['id'];

    public function kategoriJurusan()
    {
        return $this->belongsTo('App\KategoriJurusan', 'id_kategori_jurusan', 'id');
    }
}
