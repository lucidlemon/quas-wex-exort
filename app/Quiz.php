<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'question',
        'images',
        'answers',
        'correct',
        'patch_id',
        'relevant',
        'type',
        'difficulty',
        'difficultyCalculated'
    ];

    protected $casts = [
        'images' => 'array',
        'answers' => 'array',
    ];

    protected $table = 'quiz';

    public function patch()
    {
        return $this->belongsTo('App\Patch', 'id');
    }
}
