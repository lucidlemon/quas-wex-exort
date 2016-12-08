<?php

namespace App\Http\Controllers;

use App\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guide = new Guide();
        $guide->fill($request->input())->save();
        $guide->user_id = Auth::id();

        if($request->input('morph')){
            $morph = $request->input('morph');

            if(strpos($morph['value'], 'App\Hero') !== false){
                $guide->morphable_type = 'App\Hero';
                $guide->morphable_id = intval(str_replace('App\Hero\\', '', $morph['value']));
            } else if(strpos($morph['value'], 'App\Item') !== false){
                $guide->morphable_type = 'App\Item';
                $guide->morphable_id = intval(str_replace('App\Item\\', '', $morph['value']));
            } else if(strpos($morph['value'], 'App\Tactic') !== false){
                $guide->morphable_type = 'App\Tactic';
                $guide->morphable_id = intval(str_replace('App\Tactic\\', '', $morph['value']));
            }

        }

        if($request->input('patch')){
            $patch = $request->input('patch');
            $guide->patch_id = $patch['id'];
        }

        if($request->input('guide_type')){
            $guide_type = $request->input('guide_type');
            $guide->guide_type_id = $guide_type['id'];
        }

        $user = Auth::user();
        if($user->mod){
            $guide->granted = 1;
            $guide->mod_id = Auth::id();
        }

        $guide->save();

        if(!env('APP_DEBUG', false)) {
            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_GROUP_ID'),
                'text' => 'New Guide: ' . $request->input('url')
            ]);
        }

        return $guide;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
