<?php

use Dota2Api\Api;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

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

Route::get('quiz', 'QuizController@show');
Route::get('quiz/{id}', 'QuizController@show');
Route::post('quiz', 'QuizController@storeResult');

Route::get('guide/{category}', 'GuideController@index');
Route::post('guide', 'GuideController@store')->middleware('auth:api');

Route::get('/patches', function (Request $request) {
    return \App\Patch::all()->sortBy('version');
});

Route::post('/patches', function (Request $request) {
    if(\Illuminate\Support\Facades\Auth::user()->mod){
        $patches = $request->input('patches');
        foreach ($patches as $patch){
            $patch['started_at'] = \Carbon\Carbon::parse($patch['started_at']);
            $patch['ended_at'] = \Carbon\Carbon::parse($patch['ended_at']);

            if (isset($patch['id'])){
                // old
                $db_patch = \App\Patch::whereId($patch['id'])->get()->first();
                $db_patch->update($patch);
                $db_patch->save();
            } else {
                // new
                $db_patch = new \App\Patch();
                $db_patch->fill($patch);
                $db_patch->save();

                if(!env('APP_DEBUG', false)) {
                    Telegram::sendMessage([
                        'chat_id' => env('TELEGRAM_GROUP_ID'),
                        'text' => 'Patch added: ' . $patch['version']
                    ]);
                }
            }
        }
    }

    return \App\Patch::all()->sortBy('version');
})->middleware('auth:api');


//Route::resource('/oneliner', 'OneLinerController');

if(env('APP_DEBUG', false)){
    Route::get('telegram/status', 'TelegramController@getUpdates');
}

