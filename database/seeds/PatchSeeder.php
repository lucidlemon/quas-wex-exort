<?php

use App\Patch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patch::create([
            'version' => '6.88f',
            'main_version' => '6.88',
            'started_at' => Carbon::createFromDate(2016, 10, 17, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 12, 12, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.88e',
            'main_version' => '6.88',
            'started_at' => Carbon::createFromDate(2016, 10, 2, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 10, 17, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.88d',
            'main_version' => '6.88',
            'started_at' => Carbon::createFromDate(2016, 9, 2, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 10, 2, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.88c',
            'main_version' => '6.88',
            'started_at' => Carbon::createFromDate(2016, 8, 19, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 9, 2, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.88b',
            'main_version' => '6.88',
            'started_at' => Carbon::createFromDate(2016, 7, 12, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 8, 19, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.88',
            'main_version' => '6.88',
            'started_at' => Carbon::createFromDate(2016, 6, 12, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 7, 12, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.87',
            'main_version' => '6.87',
            'started_at' => Carbon::createFromDate(2016, 4, 25, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 6, 12, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.86',
            'main_version' => '6.86',
            'started_at' => Carbon::createFromDate(2015, 12, 16, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 4, 25, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.85',
            'main_version' => '6.85',
            'started_at' => Carbon::createFromDate(2015, 9, 24, 'GMT'),
            'ended_at' => Carbon::createFromDate(2015, 12, 16, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.84',
            'main_version' => '6.84',
            'started_at' => Carbon::createFromDate(2015, 4, 30, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 9, 24, 'GMT'),
        ]);

        Patch::create([
            'version' => '6.83',
            'main_version' => '6.83',
            'started_at' => Carbon::createFromDate(2014, 12, 17, 'GMT'),
            'ended_at' => Carbon::createFromDate(2016, 4, 30, 'GMT'),
        ]);
    }
}
