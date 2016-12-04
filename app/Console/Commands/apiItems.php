<?php

namespace App\Console\Commands;

use Dota2Api\Api;
use Dota2Api\Mappers\ItemsMapperDb;
use Dota2Api\Mappers\ItemsMapperWeb;
use Illuminate\Console\Command;

class apiItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches current items from Valves Database';

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

        $itemsMapperWeb = new ItemsMapperWeb();
        $items = $itemsMapperWeb->load();

        $itemsMapperDb = new ItemsMapperDb();
        $itemsMapperDb->save($items);

        return;
    }
}
