<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\QuizAnswer;
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

    public function storeResult(Request $request)
    {
        $answer = new QuizAnswer;
        $answer->quiz_id = $request->input('question_id');
        $answer->correct = $request->input('correct');

        if(!\Auth::guest()){
            $answer->user_id = \Auth::user()->id;
        } else {
            $answer->session = $request->input('session');
        }

        $answer->save();

        if(!\Auth::guest()){
            $user = \Auth::user();

            $answers = QuizAnswer::whereNull('user_id')->whereSession($request->input('session'))->get();
            foreach ($answers as $answer) {
                $answer->user_id = $user->id;
                $answer->save();
            }
        }
    }
}
