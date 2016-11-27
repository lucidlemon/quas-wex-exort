<?php

return [

    /*
     * Redirect URL after login
     */
    'redirect_url' => '/login',
    /*
     * API Key (http://steamcommunity.com/dev/apikey)
     */
    'api_key' => env('DOTA_API', 'apikey'),
    /*
     * Is using https ?
     */
    'https' => (env('APP_ENV') == 'local' ? false : true)

];
