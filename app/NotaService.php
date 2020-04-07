<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaService extends Model
{
    protected $table = 'nota_service';
    protected $guarded = ['id'];

    public function admin()
    {
        return $this->belongsTo('App\User', 'id_admin', 'id');
    }
    public function member()
    {
        return $this->belongsTo('App\User', 'id_member', 'id');
    }

    public function kupon()
    {
        return $this->belongsTo('App\Kupon', 'id_kupon', 'id');
    }

    public function barang()
    {
        return $this->hasMany('App\Barang', 'id_barang', 'id');
    }

    public function serviceBarang()
    {
        return $this->hasMany('App\ServiceBarang', 'id_nota', 'id')->where('status_pengerjaan', '!=', 'cancel');
    }
}
