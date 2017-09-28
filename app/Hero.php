<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'id', 'name', 'localized_name',
    ];

    protected $appends = ['image'];

    public function guides()
    {
        return $this->morphMany('App\Guide', 'morphable');
    }

    public function getImageAttribute(){
        return 'http://cdn.dota2.com/apps/dota2/images/heroes/'. str_replace('npc_dota_hero_', '', $this->name ) .'_full.png';
    }

    public function getInfoAttribute(){
        $infosJson = json_decode($this->scripts);

        $infos = new \stdClass();

        $infos->heroId = intval($infosJson->HeroID);

        $infos->roles = explode(',', $infosJson->Role);
	    $infos->roleLevels = explode(',', $infosJson->Rolelevels);
	    $infos->aliases = isset($infosJson->NameAliases) ? explode(',', $infosJson->NameAliases) : [];

	    $infos->ms = intval($infosJson->MovementSpeed);
	    $infos->armor = floatval($infosJson->ArmorPhysical);
	    $infos->attackMin = intval($infosJson->AttackDamageMin);
	    $infos->attackMax = intval($infosJson->AttackDamageMax);
	    $infos->baseAttackTime = floatval($infosJson->AttackRate);
	    $infos->attackAnimationPoint = intval($infosJson->AttackAnimationPoint);
	    $infos->attackRange = intval($infosJson->AttackRange);
	    $infos->projectileSpeed = intval($infosJson->ProjectileSpeed);
	    $infos->turnRate = floatval($infosJson->MovementTurnRate);

	    $infos->capabilities = $infosJson->AttackCapabilities;
	    $ranged = explode('_', $infosJson->AttackCapabilities);
	    $infos->ranged = $ranged[3] === 'RANGED';

        $attr = explode('_', $infosJson->AttributePrimary);
	    $infos->attributePrimary = studly_case($attr[count($attr) - 1]);
	    $infos->attributeStrengthBase = floatval($infosJson->AttributeBaseStrength);
	    $infos->attributeStrengthGain = floatval($infosJson->AttributeStrengthGain);
	    $infos->attributeIntelligenceBase = floatval($infosJson->AttributeBaseIntelligence);
	    $infos->attributeIntelligenceGain = floatval($infosJson->AttributeIntelligenceGain);
	    $infos->attributeAgilityBase = floatval($infosJson->AttributeBaseAgility);
	    $infos->attributeAgilityGain = floatval($infosJson->AttributeAgilityGain);

        return $infos;
    }
}
