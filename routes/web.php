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

$router->get('/', [
    'uses' => 'App\\Http\\Controllers\\TodoController@index'
]);

$router->get('/delete/{id}', [
    'uses' => 'App\\Http\\Controllers\\TodoController@delete'
]);

$router->get('/edit/{id}', [
    'uses' => 'App\\Http\\Controllers\\TodoController@editUpdate'
]);

$router->get('/create', [
    'uses' => 'App\\Http\\Controllers\\TodoController@create'
]);

$router->post('/create', [
    'uses' => 'App\\Http\\Controllers\\TodoController@createNew'
]);

$router->post('/edit/{id}', [
    'uses' => 'App\\Http\\Controllers\\TodoController@update'
]);

$router->get('/update/{id}/{checked}', [
    'uses' => 'App\\Http\\Controllers\\TodoController@updateChecked'
]);
