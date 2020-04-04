<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_lengkap', 'no_handphone', 'email', 'password', 'is_admin', 'is_user', 'status', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        if ($this->is_admin) {
            return true;
        } else {
            return false;
        }
    }
    public function tagihan()
    {
        return $this->hasMany('App\Tagihan', 'id_user', 'id');
    }

    public function tagihanFormulir()
    {
        return Tagihan::where('id_user', $this->id)->where('nama', 'formulir')->where('status', 'belum-lunas')->first();
    }
    
    public function tagihanAdmisi()
    {
        return Tagihan::where('id_user', $this->id)->where('nama', 'admisi')->where('status', 'belum-lunas')->first();
    }
}
