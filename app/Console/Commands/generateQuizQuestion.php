<?php

namespace App\Console\Commands;

use App\Hero;
use App\Patch;
use App\Quiz;
use Illuminate\Console\Command;

class generateQuizQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:generate {count=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new random question';

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
     */
    public function handle()
    {
        for ($i = 0; $i < $this->argument('count'); $i++) {
	        dispatch(new \App\Jobs\generateQuizQuestion());
        }
    }
}
