<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guide extends Model
{
  use SoftDeletes;

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

  public function patch()
  {
    return $this->belongsTo('App\Patch', 'id');
  }
}
