<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OneLiner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function mod()
    {
        return $this->belongsTo('App\User', 'mod_id');
    }
}
