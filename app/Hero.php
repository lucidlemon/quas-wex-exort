<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'id', 'name', 'localized_name',
    ];

    public function guides()
    {
        return $this->morphMany('App\Guide', 'morphable');
    }
}
