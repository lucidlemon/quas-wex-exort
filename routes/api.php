<?php

use Dota2Api\Api;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/user-yolo', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::get('/items', function (Request $request) {

    Api::init(env('DOTA_API', 'apikey'), ['localhost', env('DB_USERNAME', 'username'), env('DB_PASSWORD', 'username'), env('DB_DATABASE', 'username'), '']);

    $itemsMapperWeb = new Dota2Api\Mappers\ItemsMapperWeb();
    $itemsInfo = $itemsMapperWeb->load();

    $itemsJson = [];

    foreach($itemsInfo as $item) {
        $itemsJson[] = [
            "id" => $item->get('id'),
            "name" => $item->get('name'),
            "cost" => $item->get('cost'),
            "secret_shop" => $item->get('secret_shop'),
            "side_shop" => $item->get('side_shop'),
            "recipe" => $item->get('recipe'),
            "localized_name" => $item->get('localized_name'),
        ];
    }

    return $itemsJson;
});

Route::get('oneliner/single/{id}', 'OneLinerController@showRandom');
Route::get('oneliner', 'OneLinerController@index')->middleware('auth:api');
Route::post('oneliner', 'OneLinerController@store')->middleware('auth:api');
//Route::put($uri, $callback);
//Route::patch($uri, $callback);
//Route::delete($uri, $callback);
//Route::options($uri, $callback);


//Route::resource('/oneliner', 'OneLinerController');

if(env('APP_DEBUG', false)){
    Route::get('telegram/status', 'TelegramController@getUpdates');
}

