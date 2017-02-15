<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
          $table->increments('id');

          $table->string('text', 1024);
          $table->boolean('correct')->default(0);
          $table->boolean('granted')->default(0);

          $table->integer('quiz_question_id')->unsigned();
          $table->foreign('quiz_question_id')->references('id')->on('quiz_questions');

          $table->integer('mod_id')->unsigned()->nullable();
          $table->foreign('mod_id')->references('id')->on('users');

          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('quiz_answers');
    }
}
