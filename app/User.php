<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'steamid', 'avatar', 'reddit', 'twitter'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function oneliners()
    {
        return $this->hasMany('App\OneLiner', 'user_id', 'id');
    }

    public function onelinersAuthorized()
    {
        return $this->hasMany('App\OneLiner', 'mod_id', 'id');
    }
}
