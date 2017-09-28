<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->increments('id');

            $table->mediumText('question');
            $table->text('images');
            $table->text('answers');
            $table->string('correct')->nullable();

            $table->integer('patch_id')->unsigned()->nullable();
            $table->foreign('patch_id')->references('id')->on('patches');

            $table->boolean('relevant')->default(1);
            $table->string('type')->nullable();
            $table->tinyInteger('difficulty')->unsigned()->default(128);
            $table->bigInteger('difficultyCalculated')->default(0);

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
        Schema::dropIfExists('quiz');
    }
}
