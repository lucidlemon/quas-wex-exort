<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
  protected $fillable = [
    'text',
    'correct',
  ];

  public function question()
  {
    return $this->belongsTo('App\QuizQuestion');
  }
}
