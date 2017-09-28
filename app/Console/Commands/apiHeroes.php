<?php

namespace App\Console\Commands;

use App\Hero;
use Dota2Api\Api;
use Dota2Api\Mappers\HeroesMapper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class apiHeroes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:heroes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches current heroes from Valves Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // start to fetch data from official Dota 2 API by Valve
        $this->info('Fetching Dota 2 API');
        Api::init(env('DOTA_API', 'apikey'), ['localhost', env('DB_USERNAME', 'username'), env('DB_PASSWORD', 'username'), env('DB_DATABASE', 'dbname'), '']);

        $heroesMapper = new HeroesMapper();
        $heroes = $heroesMapper->load();

        $obj = false;
	    $objAbilities = false;

	    // download data from dotabuff's converted game assets for up to date data
        // save it into local storage for further usage
        try {
            $this->info('Downloading Hero Infos');
	        $jsonHero = file_get_contents('https://github.com/dotabuff/d2vpkr/raw/master/dota/scripts/npc/npc_heroes.json');
	        Storage::put('npc_heroes.json', $jsonHero);
	        $obj = json_decode($jsonHero, true);

            $this->info('Downloading Ability Infos');
	        $jsonAbilities = file_get_contents('https://github.com/dotabuff/d2vpkr/raw/master/dota/scripts/npc/npc_abilities.json');
	        Storage::put('npc_abilities.json', $jsonAbilities);
	        $objAbilities = json_decode($jsonAbilities, true);

	        // english translation files, might use others later - but i doubt that
            $this->info('Downloading Translation');
	        $jsonEnglish = file_get_contents('https://github.com/dotabuff/d2vpkr/raw/master/dota/resource/dota_english.json');
	        Storage::put('dota_english.json', $jsonEnglish);
	        $objEnglish = json_decode($jsonEnglish, true);
        } catch (\Exception $e) {
	        echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        // iterate through each fetched hero and refresh some data
        foreach($heroes as $hero){
            // search for the hero, if he's not here, create it
            $dbhero = Hero::firstOrCreate($hero);
            $this->info('Analyzing ' . $dbhero->localized_name);

            //  did the json call work?
            if ($obj !== false && $objAbilities !== false) {
                // iterate through the heroes abilities and save them. they appear to be numbered 1-6
	            $abilities = [];
	            for ($i = 1; $i < 10; $i++){
		            if (isset($obj['DOTAHeroes'][$hero['name']]['Ability' . $i])) {
			            $abilityname = $obj['DOTAHeroes'][$hero['name']]['Ability' . $i];
			            $abilities[] = $objAbilities['DOTAAbilities'][$abilityname];
		            }
                }

                // starting with 10 they introduce talents as well
                $talents = [];
	            for ($i = 10; $i < 20; $i++){
		            if (isset($obj['DOTAHeroes'][$hero['name']]['Ability' . $i])) {
			            $abilityname = $obj['DOTAHeroes'][$hero['name']]['Ability' . $i];
			            $talents[] = $objAbilities['DOTAAbilities'][$abilityname];
		            }
	            }

	            // save all this data as json into the database
                $dbhero->scripts = json_encode($obj['DOTAHeroes'][$hero['name']]);
	            $dbhero->abilities = json_encode($abilities);
                $dbhero->talents = json_encode($talents);
            }

            // save it into db
            $dbhero->save();

            // start to prepare hero info for easier reading and exporting
            $infosJson = json_decode($dbhero->scripts);

            // save it as an object, just easier to handle within js APIs
            $infos = new \stdClass();

            // ultimate basics
            $infos->heroId = intval($infosJson->HeroID);

            // general infos about the hero
            $infos->roles = explode(',', $infosJson->Role);
            $infos->roleLevels = explode(',', $infosJson->Rolelevels);
            $infos->aliases = isset($infosJson->NameAliases) ? explode(',', $infosJson->NameAliases) : [];

            // everything actual fight related
            $infos->ms = intval($infosJson->MovementSpeed);
            $infos->armor = floatval($infosJson->ArmorPhysical);
            $infos->attackMin = intval($infosJson->AttackDamageMin);
            $infos->attackMax = intval($infosJson->AttackDamageMax);
            $infos->baseAttackTime = floatval($infosJson->AttackRate);
            $infos->attackAnimationPoint = intval($infosJson->AttackAnimationPoint);
            $infos->attackRange = intval($infosJson->AttackRange);
            $infos->projectileSpeed = isset($infosJson->ProjectileSpeed) ? intval($infosJson->ProjectileSpeed) : 0;
            $infos->turnRate = floatval($infosJson->MovementTurnRate);
            $infos->nightVision = isset($infosJson->VisionNighttimeRange) ? intval($infosJson->VisionNighttimeRange) : 800;

            // is a bit weird in the dota api, lets store it as a bool
            $infos->attackCapabilities = $infosJson->AttackCapabilities;
            $ranged = explode('_', $infosJson->AttackCapabilities);
            $infos->ranged = $ranged[3] === 'RANGED';

            // primary attribute is stored as some namespaced string, let's make it easier
            $attr = explode('_', $infosJson->AttributePrimary);
            $infos->attributePrimary = studly_case($attr[count($attr) - 1]);

            // basic stats
            $infos->attributeStrengthBase = floatval($infosJson->AttributeBaseStrength);
            $infos->attributeStrengthGain = floatval($infosJson->AttributeStrengthGain);
            $infos->attributeIntelligenceBase = floatval($infosJson->AttributeBaseIntelligence);
            $infos->attributeIntelligenceGain = floatval($infosJson->AttributeIntelligenceGain);
            $infos->attributeAgilityBase = floatval($infosJson->AttributeBaseAgility);
            $infos->attributeAgilityGain = floatval($infosJson->AttributeAgilityGain);

            // store all this data into database
            $dbhero->info = json_encode($infos);
            $dbhero->save();
        }
    }
}
