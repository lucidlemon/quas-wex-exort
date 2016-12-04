<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patch extends Model
{
    protected $fillable = [
        'version', 'main_version', 'title', 'started_at', 'ended_at',
    ];
}
