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

$router->get('/', 'MainController@index');

$router->post('/login', 'SessionController@login');

$router->group(['middleware' => 'sessionAuth', 'prefix' => 'client'], function ($router) 
{
    $router->get('check-in', 'MainController@clientCheckIn');
    $router->get('list/{phone}', 'MainController@clientCheckInsList');
    
    $router->post('check', 'ClientController@checkExists');
    $router->get('register/{phone}', 'ClientController@create');
    $router->post('store', 'ClientController@store');
});


/* 
 * Auth API Routes
 */
$router->group(['middleware' => 'auth','prefix' => 'api'], function ($router) 
{
    $router->get('me', 'AuthController@me');
});
$router->group(['prefix' => 'api'], function () use ($router) 
{
   $router->post('register', 'AuthController@register');
   $router->post('login', 'AuthController@login');
});