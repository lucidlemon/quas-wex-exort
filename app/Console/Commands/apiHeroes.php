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
        Api::init(env('DOTA_API', 'apikey'), ['localhost', env('DB_USERNAME', 'username'), env('DB_PASSWORD', 'username'), env('DB_DATABASE', 'dbname'), '']);

        $heroesMapper = new HeroesMapper();
        $heroes = $heroesMapper->load();

        $obj = false;
	    $objAbilities = false;

	    // download data from dotabuff's converted game assets for up to date data
        // save it into local storage for further usage
        try {
	        $jsonHero = file_get_contents('https://github.com/dotabuff/d2vpkr/raw/master/dota/scripts/npc/npc_heroes.json');
	        Storage::put('npc_heroes.json', $jsonHero);
	        $obj = json_decode($jsonHero, true);

	        $jsonAbilities = file_get_contents('https://github.com/dotabuff/d2vpkr/raw/master/dota/scripts/npc/npc_abilities.json');
	        Storage::put('npc_abilities.json', $jsonAbilities);
	        $objAbilities = json_decode($jsonAbilities, true);

	        // english translation files, might use others later - but i doubt that
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
            $dbhero->generateInfos();
        }
    }
}
