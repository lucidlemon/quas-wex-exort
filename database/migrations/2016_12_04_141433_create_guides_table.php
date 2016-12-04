<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->increments('id');

            $table->string('url', 1024);
            $table->string('title', 1024);
            $table->string('desc', 1024);
            $table->boolean('granted')->default(0);

            $table->integer('guide_type_id')->unsigned()->nullable();
            $table->foreign('guide_type_id')->references('id')->on('guide_types');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('mod_id')->unsigned()->nullable();
            $table->foreign('mod_id')->references('id')->on('users');

            $table->integer('patch_id')->unsigned()->nullable();
            $table->foreign('patch_id')->references('id')->on('patches');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guides');
    }
}
