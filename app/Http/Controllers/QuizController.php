<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = false)
    {
        // if ($id) {
        //     return Quiz::findOrFail($id);
        // }
        
        $quiz = Quiz::inRandomOrder()->first();
        $quiz->answers = json_decode($quiz->answers);
        $quiz->images = json_decode($quiz->images);

        return $quiz;
    }
}
