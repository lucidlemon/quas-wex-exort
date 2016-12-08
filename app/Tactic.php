<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tactic extends Model
{
    protected $fillable = [
        'id', 'title', 'slug'
    ];

    public function guides()
    {
        return $this->morphMany('App\Guide', 'morphable');
    }
}
