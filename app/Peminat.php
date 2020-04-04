<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminat extends Model
{
    protected $table = 'peminat';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }
}
