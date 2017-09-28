<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePreviousQuizTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $answers = new CreateQuizAnswersTable;
        $answers->down();

        $questions = new CreateQuizQuestionsTable;
        $questions->down();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $questions = new CreateQuizQuestionsTable;
        $questions->up();

        $answers = new CreateQuizAnswersTable;
        $answers->up();
    }
}
