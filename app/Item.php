<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'id', 'name', 'localized_name', 'cost', 'secret_shop', 'side_shop', 'recipe'
    ];

    protected $appends = ['image'];

    public function guides()
    {
        return $this->morphMany('App\Guide', 'morphable');
    }

    public function getImageAttribute(){
        return 'http://cdn.dota2.com/apps/dota2/images/items/'.str_replace('item_', '', $this->name ).'_lg.png';
    }
}
