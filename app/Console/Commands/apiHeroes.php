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
        Api::init(env('DOTA_API', 'apikey'), ['localhost', env('DB_USERNAME', 'username'), env('DB_PASSWORD', 'username'), env('DB_DATABASE', 'dbname'), '']);

        $heroesMapper = new HeroesMapper();
        $heroes = $heroesMapper->load();

        $obj = false;
	    $objAbilities = false;

        try {
	        $jsonHero = file_get_contents('https://github.com/dotabuff/d2vpkr/raw/master/dota/scripts/npc/npc_heroes.json');
	        Storage::put('npc_heroes.json', $jsonHero);
	        $obj = json_decode($jsonHero, true);

	        $jsonAbilities = file_get_contents('https://github.com/dotabuff/d2vpkr/raw/master/dota/scripts/npc/npc_abilities.json');
	        Storage::put('npc_abilities.json', $jsonAbilities);
	        $objAbilities = json_decode($jsonAbilities, true);

	        $jsonEnglish = file_get_contents('https://github.com/dotabuff/d2vpkr/raw/master/dota/resource/dota_english.json');
	        Storage::put('dota_english.json', $jsonEnglish);
	        $objEnglish = json_decode($jsonEnglish, true);
        } catch (\Exception $e) {
	        echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        foreach($heroes as $hero){
            $dbhero = Hero::firstOrCreate($hero);

            if ($obj !== false && $objAbilities !== false) {
	            $dbhero->scripts = json_encode($obj['DOTAHeroes'][$hero['name']]);

	            $abilities = [];
	            $talents = [];

	            for ($i = 1; $i < 10; $i++){
		            if (isset($obj['DOTAHeroes'][$hero['name']]['Ability' . $i])) {
			            $abilityname = $obj['DOTAHeroes'][$hero['name']]['Ability' . $i];
			            $abilities[] = $objAbilities['DOTAAbilities'][$abilityname];
		            }
                }

	            for ($i = 10; $i < 20; $i++){
		            if (isset($obj['DOTAHeroes'][$hero['name']]['Ability' . $i])) {
			            $abilityname = $obj['DOTAHeroes'][$hero['name']]['Ability' . $i];
			            $talents[] = $objAbilities['DOTAAbilities'][$abilityname];
		            }
	            }

	            $dbhero->abilities = json_encode($abilities);
                $dbhero->talents = json_encode($talents);
            }

            $dbhero->save();
        }
    }
}
