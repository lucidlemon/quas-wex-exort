<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'id', 'name', 'localized_name',
    ];

    protected $appends = ['image', 'infos'];

    public function guides()
    {
        return $this->morphMany('App\Guide', 'morphable');
    }

    public function getImageAttribute(){
        return 'http://cdn.dota2.com/apps/dota2/images/heroes/'. str_replace('npc_dota_hero_', '', $this->name ) .'_full.png';
    }

    public function getInfosAttribute(){
        return json_decode($this->info);
    }
}
