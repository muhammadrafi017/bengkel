<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaProduk extends Model
{
    protected $table = 'nota_produk';
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

    public function detailNota()
    {
        return $this->hasMany('App\DetailNotaProduk', 'id_nota', 'id');
    }
}
