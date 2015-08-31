<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->routeMiddleware([
    'apilumen' => 'App\Http\Middleware\ApiLumenMiddleware',
]);

$app->group(array('namespace' => 'App\Http\Controllers', 'prefix' => 'api/v1', 'middleware' => array('apilumen')), function( $group ) use ( $app )
{
    $group->get('movies', 'MovieController@index');
    $group->get('movies/{id}', 'MovieController@show');
    $group->post('movies', 'MovieController@store');
    $group->patch('movies/{id}', 'MovieController@update');
    $group->delete('movies/{id}', 'MovieController@destroy');
    $group->put('movies/{id}', 'MovieController@restore');
});
