<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('auth/login', ['uses' => 'AuthController@login']);

$router->group(['prefix' => 'api','middleware' => 'auth'], function () use ($router){
    $router->group(['prefix' => 'ticket'], function () use ($router){
        $router->get('/',  ['uses' => 'TicketController@index']);

        $router->get('/{id}', ['uses' => 'TicketController@view']);

        $router->post('/', ['uses' => 'TicketController@create']);

        $router->put('/{id}', ['uses' => 'TicketController@update']);
        
        $router->delete('/{id}', ['uses' => 'TicketController@delete']);

    });
});
