<?php

namespace App\Http\Controllers;

use App\OneLiner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
//        $oneliner = OneLiner::create($request->input());
//        dd(Auth::user());
        $oneliner->user_id = Auth::id();
        $oneliner->save();
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
    public function showRandom()
    {
        return \App\OneLiner::inRandomOrder()->whereGranted(1)->get()->first();
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
