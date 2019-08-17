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

Auth::routes();

Route::redirect('/','dashboard');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/dashboard/admin', 'AdminController@index')->name('admin');

Route::get('/scoring', 'ScoringController@index')->name('scoring');

Route::post('/scoring', 'ScoringController@validate')->name('scoring.check');

Route::post('/scoring/save', 'ScoringController@saveScore')->name('savescore');

Route::get('/scoring/active', 'ActiveEntryController@index')->name('scoring.active');

Route::get('/dashboard/admin/find', 'AdminController@findEntry')->name('find.entry');

Route::post('/dashboard/admin/activate', 'AdminController@activateEntry')->name('set.active');

Route::post('/dashboard/admin/clear', 'AdminController@clearEntry')->name('set.clear');

Route::get('/dashboard/admin/getactive', 'AdminController@getActive')->name('get.active');

Route::get('/dashboard/livescoring', 'LiveScoringController@index')->name('livescoring');

Route::get('/dashboard/ranking', 'RankingController@index')->name('ranking');

Route::post('/dashboard/ranking', 'RankingController@show')->name('ranking.show');