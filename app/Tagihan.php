<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }
}
