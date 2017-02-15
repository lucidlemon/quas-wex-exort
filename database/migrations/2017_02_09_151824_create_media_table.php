<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('media', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();

      $table->string('title', 1024)->nullable();
      $table->string('type');
      $table->string('filename', 1024);

      $table->integer('morphable_id')->unsigned()->nullable();
      $table->string('morphable_type')->nullable();

      $table->index('morphable_id');
      $table->index('morphable_type');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('media');
  }
}
