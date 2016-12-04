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

Route::get('/', function () {
    return view('welcome', ['manual' => 'false']);
});

Route::get('/manual-timer', function () {
    return view('welcome', ['manual' => 'true']);
});

Route::get('/overview/items', function () {
    return view('overview/items');
});

Route::get('/oneliner', function () {
    return view('overview/oneliner');
});






Route::get('/guides', function () {
    return view('guides/overview');
});

Route::get('/guides/post', function () {
    $heroes = \App\Hero::orderBy('localized_name')->get(['id', 'localized_name']);
    $items = \App\Item::orderBy('localized_name')->get(['id', 'localized_name', 'recipe']);

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

    return view('guides/create', ['morphs' => $morphs]);
});

Route::get('/guides/{category}', function ($category) {
    if($category === 'heroes'){
        $guides = \App\Hero::orderBy('localized_name')
            ->with(['guides' => function($query){
                $query->where('granted', 'is', 1);
            }])
            ->get();
    } else if($category === 'items'){
        $guides = \App\Item::orderBy('localized_name')
            ->with(['guides' => function($query){
                $query->where('granted', 'is', 1);
            }])
            ->where('recipe', 0)
            ->where('id', '<', 1000)
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


Route::get('/test', function () {
    Api::init(env('DOTA_API', 'apikey'), ['localhost', env('DB_USERNAME', 'username'), env('DB_PASSWORD', 'username'), env('DB_DATABASE', 'dbname'), '']);

});