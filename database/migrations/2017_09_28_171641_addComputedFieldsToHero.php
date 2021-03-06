<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComputedFieldsToHero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('heroes', function (Blueprint $table) {
            $table->text('info')->nullable()->after('localized_name');
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
            $table->dropColumn('info');
        });
    }
}
