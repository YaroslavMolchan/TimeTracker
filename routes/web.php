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

Route::get('/', 'TimerController@index');

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('login');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::post('timer/start', 'TimerController@start')->name('timer.start');
Route::post('timer/stop', 'TimerController@stop')->name('timer.stop');

Route::post('statistic/daily-team', 'StatisticController@dailyTeam')->name('statistic.daily-team');
Route::post('statistic/daily-user', 'StatisticController@dailyUser')->name('statistic.daily-user');
