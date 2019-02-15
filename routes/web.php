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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/task1', 'GameParserController@task1');
Route::get('/task2', 'GameParserController@task2');
Route::get('/task3', 'GameParserController@task3');
Route::post('/search', 'GameParserController@search');
Route::get('/search', 'GameParserController@search');