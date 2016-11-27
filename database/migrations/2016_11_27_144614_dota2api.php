<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dota2api extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(file_get_contents('vendor/kronusme/dota2-api/db_latest.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('ability_upgrades');
        Schema::drop('additional_units');
        Schema::drop('items');
        Schema::drop('league_prize_pools');
        Schema::drop('leagues');
        Schema::drop('matches');
        Schema::drop('picks_bans');
        DB::unprepared('SET FOREIGN_KEY_CHECKS = 1');
    }
}
