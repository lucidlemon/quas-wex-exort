<?php

namespace App\Console\Commands;

use App\Hero;
use Dota2Api\Api;
use Dota2Api\Mappers\HeroesMapper;
use Illuminate\Console\Command;

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

        try {
  	        $json = file_get_contents('https://raw.githubusercontent.com/dotabuff/d2vpkr/master/dota/scripts/npc/npc_heroes.json');
	          $obj = json_decode($json, true);
        } catch (\Exception $e) {
	        echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        foreach($heroes as $hero){
            $dbhero = Hero::firstOrCreate($hero);

            if ($obj !== false) {
	            $dbhero->scripts = json_encode($obj['DOTAHeroes'][$hero['name']]);
            }

            $dbhero->save();
        }
    }
}
