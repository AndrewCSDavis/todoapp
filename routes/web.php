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
    'uses' => 'TodoController@index'
]);

$router->get('/delete/{id}', [
    'uses' => 'TodoController@delete'
]);

$router->get('/edit/{id}', [
    'uses' => 'TodoController@editUpdate'
]);

$router->get('/create', [
    'uses' => 'TodoController@create'
]);

$router->post('/create', [
    'uses' => 'TodoController@createNew'
]);

$router->post('/edit/{id}', [
    'uses' => 'TodoController@update'
]);

$router->get('/update/{id}/{checked}', [
    'uses' => 'TodoController@updateChecked'
]);
