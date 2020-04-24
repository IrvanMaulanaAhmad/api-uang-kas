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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->get('/api/', ['middleware' => 'auth', 'uses' => 'DashboardController@index']); // Read total Balance + Total Transaction In + Total Transaction Out from all user

// User - List | for Admins
$router->group(['prefix' => 'api/users/', 'middleware' => 'auth'], function() use ($router){
    $router->get('/', 'UserController@index'); // Read all Users List from User Model
    $router->get('/{id}', 'UserController@show'); // Read Users with match ID | also SHOW his/her Transaction In and Transaction Out List
    $router->put('/{id}/update', 'UserController@update'); // Update User data with match ID | only allowed to modify 'Status' data
});

// Transaction In
$router->group(['prefix' => 'api/transaction/in', 'middleware' => 'auth'], function() use ($router){
    $router->get('/', 'TransactionInController@index'); // Read all TransactionIn List from Transaction In Model
    $router->get('/user/{id}', 'TransactionInController@list'); // Read Transaction In based on User ID
    $router->get('/{id}/', 'TransactionInController@show'); // Read Transaction In with match ID
    $router->post('/store', 'TransactionInController@store'); // Store Transaction In data
    $router->patch('/{id}/update', 'TransactionInController@update'); // Edit Transaction In data
});

// Transaction Out
$router->group(['prefix' => 'api/transaction/out', 'middleware' => 'auth'], function() use ($router){
    $router->get('/', 'TransactionOutController@index'); // Read all TransactionIn List from Transaction In Model
    $router->get('/user/{id}', 'TransactionOutController@list'); // Read Transaction In based on User ID
    $router->get('/{id}/', 'TransactionOutController@show'); // Read Transaction In with match ID
    $router->post('/store', 'TransactionOutController@store'); // Store Transaction In data
    $router->patch('/{id}/update', 'TransactionOutController@update'); // Edit Transaction In data
});

// Auth
$router->group(['prefix' => 'api/auth'], function() use ($router){
    $router->post('/login', 'AuthController@login'); // for Login API. use This. it will return the API KEY
    $router->post('/register', 'AuthController@register'); // for register API. use This. it will not return the API KEY
});