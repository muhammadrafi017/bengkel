<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceBarang extends Model
{
    protected $table = 'service_barang';
    protected $guarded = ['id'];

    public function nota()
    {
        return $this->belongsTo('App\NotaService', 'id_nota', 'id');
    }

    public function barang()
    {
        return $this->hasOne('App\Barang', 'id', 'id_barang');
    }

    public function barang_nota()
    {
        return $this->hasMany('App\Barang', 'id', 'id_barang');
    }

    public function service()
    {
        return $this->hasOne('App\Service', 'id', 'id_service');
    }

    public function mekanik()
    {
        return $this->hasOne('App\Mekanik', 'id', 'id_mekanik');
    }
}
