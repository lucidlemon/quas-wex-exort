<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizQuestionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('quiz_questions', function (Blueprint $table) {
      $table->increments('id');

      $table->string('title', 1024);
      $table->text('desc');
      $table->boolean('granted')->default(0);

      $table->integer('user_id')->unsigned()->nullable();
      $table->foreign('user_id')->references('id')->on('users');

      $table->integer('mod_id')->unsigned()->nullable();
      $table->foreign('mod_id')->references('id')->on('users');

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
    Schema::dropIfExists('quiz_questions');
  }
}
