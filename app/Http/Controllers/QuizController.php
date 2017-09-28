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
        if ($id) {
            return Quiz::findOrFail($id);
        }

        return Quiz::inRandomOrder()->first();
    }
}
