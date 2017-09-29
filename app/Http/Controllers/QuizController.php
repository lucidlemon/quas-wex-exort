<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\QuizAnswer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        if(!session('quiz_session')){
            $quizSession = str_random(64);
            session(['quiz_session' => $quizSession]);
        } else {
            $quizSession = session('quiz_session');
        }

        if(\Auth::guest()){
            $mmr = 2000;
            $mmr += \App\QuizAnswer::whereSession($quizSession)->whereCorrect(true)->count() * 25;
            $mmr -= \App\QuizAnswer::whereSession($quizSession)->whereCorrect(false)->count() * 25;
        } else {
            $user = \Auth::user();

            $answers = QuizAnswer::whereNull('user_id')->whereSession($quizSession)->get();
            foreach ($answers as $answer) {
                $answer->user_id = $user->id;
                $answer->save();
            }

            $mmr = \Auth::user()->quizMmr;
        }

        return view('overview/quiz')->with(['mmr' => $mmr, 'quizSession' => $quizSession]);
    }

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

        $quiz = Quiz::where('created_at', '>', Carbon::now()->subDay())->inRandomOrder()->first();
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
    }
}
