<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'url',
        'title',
        'desc',
    ];

    public function morphable()
    {
        return $this->morphTo();
    }

    public function guide_type()
    {
        return $this->hasOne('App\GuideType', 'id', 'guide_type_id');
    }
}
