<?php

namespace App\Console\Commands;

use App\Hero;
use Illuminate\Console\Command;

class getHeroInfos extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'info:hero {hero=Anti-Mage}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Returns Information of the requested hero';

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
		$heroName = $this->argument('hero');
		$this->info('Searching for Hero ' . $heroName);

		$hero = Hero::whereLocalizedName($heroName)->get()->first();
		$this->info('Found ' . $hero->name);

		dd($hero->infos);
	}
}
