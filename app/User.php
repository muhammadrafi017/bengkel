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
        'nama_lengkap', 'no_handphone', 'email', 'password', 'is_owner', 'is_admin', 'is_member', 'kode'
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

    public function hasAnyActors($actors)
    {
      if (is_array($actors)) {
        foreach ($actors as $actor) {
          if ($this->{'is_'.$actor}) {
            return true;
          }
        }
        return false;
      } else {
        if ($this->{'is_'.$actors}) {
          return true;
        }
        return false;
      }
    }
}
