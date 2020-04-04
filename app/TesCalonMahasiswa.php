<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TesCalonMahasiswa extends Model
{
    protected $table = 'tes_calon_mahasiswa';
    protected $guarded = ['id'];

    public function calonMahasiswa()
    {
        return $this->belongsTo('App\CalonMahasiswa', 'id_calon_mahasiswa');
    }
}
