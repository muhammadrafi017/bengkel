<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalonMahasiswa extends Model
{
    protected $table = 'calon_mahasiswa';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }

    public function gelombang()
    {
        return $this->belongsTo('App\Gelombang', 'id_gelombang', 'id');
    }
    
    public function jurusan()
    {
        return $this->belongsTo('App\Jurusan', 'id_jurusan', 'id');
    }

    public function tes()
    {
        return $this->hasOne('App\TesCalonMahasiswa', 'id_calon_mahasiswa', 'id');
    }
}
