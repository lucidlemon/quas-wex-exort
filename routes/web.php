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

Route::get('/login', 'Auth\SteamController@login');

Route::get('/logout', function (\Symfony\Component\HttpFoundation\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->flush();
    return redirect('/');
});


Route::get('/test', function () {
    Api::init(env('DOTA_API', 'apikey'), ['localhost', env('DB_USERNAME', 'username'), env('DB_PASSWORD', 'username'), env('DB_DATABASE', 'dbname'), '']);

});