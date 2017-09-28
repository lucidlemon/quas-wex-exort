<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScriptsToHeroes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('heroes', function (Blueprint $table) {
		    $table->text('talents')->nullable()->after('localized_name');
		    $table->text('abilities')->nullable()->after('localized_name');
		    $table->text('scripts')->nullable()->after('localized_name');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('heroes', function (Blueprint $table) {
		    $table->dropColumn('talents');
		    $table->dropColumn('abilities');
		    $table->dropColumn('scripts');
	    });
    }
}
