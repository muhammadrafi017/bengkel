<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriJurusan extends Model
{
    protected $table = 'kategori_jurusan';
    protected $guarded = ['id'];

    public function jurusan()
    {
        return $this->hasMany('App\Jurusan', 'id_kategori_jurusan', 'id');
    }
}
