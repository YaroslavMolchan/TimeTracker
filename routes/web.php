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

Route::get('statistic/team/daily', 'StatisticController@dailyTeam')->name('statistic.daily-team');
Route::get('statistic/team/weekly', 'StatisticController@weeklyTeam')->name('statistic.weekly-team');

Route::post('statistic/team/daily', 'StatisticController@ajaxDailyTeam')->name('statistic.daily-team');
Route::post('statistic/user/daily', 'StatisticController@ajaxDailyUser')->name('statistic.daily-user');
