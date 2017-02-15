<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
  protected $fillable = [
    'title',
    'desc',
  ];

  public function answers()
  {
    return $this->hasMany('App\QuizAnswer');
  }

  public function media()
  {
    return $this->morphMany('App\Media', 'morphable');
  }
}
