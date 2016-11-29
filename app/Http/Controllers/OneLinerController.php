<?php

namespace App\Http\Controllers;

use App\Notifications\NewOneliner;
use App\OneLiner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class OneLinerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OneLiner::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $oneliner = new OneLiner();
        $oneliner->fill($request->input())->save();
        $oneliner->user_id = Auth::id();

        $user = Auth::user();
        if($user->mod){
            $oneliner->granted = 1;
            $oneliner->mod_id = Auth::id();
        }

        $oneliner->save();

        if(!env('APP_DEBUG', false)) {
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_GROUP_ID'),
                'text' => 'New Oneliner: ' . $request->input('text')
            ]);
        }

        return $oneliner;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return OneLiner::find($id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showRandom($id)
    {
        return \App\OneLiner::inRandomOrder()->where('id', '<>', $id)->whereGranted(1)->get()->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $oneline = OneLiner::updateOrCreate(
            ['id' => $id],
            $request->input()
        );
        return $oneline;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return OneLiner::find($id)->delete();
    }
}
