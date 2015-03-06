<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('forecast','ForecastController@index');
Route::get('currentLocal', 'HomeController@currentLocal');


Route::get('currentSetPoint', 'HomeController@currentSetPoint');
Route::get('updateSetPoint/{temperature}', 'HomeController@updateSetPoint');