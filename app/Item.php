<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'id', 'name', 'localized_name', 'cost', 'secret_shop', 'side_shop', 'recipe'
    ];
}
