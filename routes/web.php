<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Dota2Api\Api;
use Dota2Api\Mappers\ItemsMapperDb;
use Dota2Api\Mappers\ItemsMapperWeb;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', ['manual' => 'false']);
});

Route::get('/manual-timer', function () {
    return view('welcome', ['manual' => 'true']);
});

Route::get('/about', function () {
  return view('readonly.about');
});

Route::get('/overview/items', function () {
    return view('overview/items');
});

Route::get('/oneliner', function () {
    return view('overview/oneliner');
});

Route::get('/patches', function () {
    return view('overview/patches');
});

Route::get('/quiz', function () {
    return view('overview/quiz');
});



Route::get('/guides', function () {
    return view('guides/overview');
});

Route::get('/guides/post', function () {
    $heroes = \App\Hero::orderBy('localized_name')->get(['id', 'localized_name']);
    $items = \App\Item::orderBy('localized_name')->get(['id', 'localized_name', 'recipe']);
    $tactics = \App\Tactic::orderBy('title')->get(['id', 'title']);

    $morphs = [];

    foreach($heroes as $hero){
        $morphs[] = (object)[
            'value' => 'App\Hero\\' . $hero->id,
            'text' => $hero->localized_name
        ];
    }

    foreach($items as $item){
        if($item->id < 1000 && $item->recipe == 0){
            $morphs[] = (object)[
                'value' => 'App\Item\\' . $item->id,
                'text' => $item->localized_name
            ];
        }
    }

    foreach($tactics as $tactic){
        $morphs[] = (object)[
            'value' => 'App\Tactic\\' . $tactic->id,
            'text' => $tactic->title
        ];
    }

    return view('guides/create', ['morphs' => $morphs]);
});

Route::get('/guides/{category}', function ($category) {
    if($category === 'heroes'){
        $guides = \App\Hero::orderBy('localized_name')
            ->with(['guides' => function($query){
                $query->whereGranted(1);
            }])
            ->get();
    } else if($category === 'items'){
        $guides = \App\Item::orderBy('localized_name')
            ->with(['guides' => function($query){
                $query->whereGranted(1);
            }])
            ->where('recipe', 0)
            ->where('id', '<', 1000)
            ->get();
    } else if($category === 'tactics'){
        $guides = \App\Tactic::orderBy('title')
            ->with(['guides' => function($query){
                $query->whereGranted(1);
            }])
            ->get();
    }

    return view('guides/category', ['category' => $category, 'guides' => $guides]);
});





Route::get('/login', 'Auth\SteamController@login');

Route::get('/logout', function (\Symfony\Component\HttpFoundation\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->flush();
    return redirect('/');
});
