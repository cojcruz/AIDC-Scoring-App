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

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CategoriesImport;
use App\Imports\EntriesImport;
use App\Imports\SchoolsImport;

Auth::routes();

Route::redirect('/','dashboard');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/dashboard/admin', 'AdminController@index')->name('admin');

Route::get('/scoring', 'ScoringController@index')->name('scoring');

Route::post('/scoring', 'ScoringController@validate')->name('scoring.check');

Route::post('/scoring/save', 'ScoringController@saveScore')->name('savescore');

Route::post('/scoring/validate', 'ScoringController@checkScores')->name('score.validation');

Route::post('/scoring/checkActive', 'ScoringController@checkActive')->name('score.checkActive');

Route::post('/scoring/validateEntry', 'ScoringController@validateEntry')->name('score.validateEntry');

Route::get('/scoring/active', 'ActiveEntryController@index')->name('scoring.active');

Route::get('/dashboard/admin/find', 'AdminController@findEntry')->name('find.entry');

Route::post('/dashboard/admin/activate', 'AdminController@activateEntry')->name('set.active');

Route::get('/dashboard/admin/activate/{id}', 'AdminController@setEntry')->name('set.activate');

Route::post('/dashboard/admin/clear', 'AdminController@clearEntry')->name('set.clear');

Route::get('/dashboard/admin/clear/{id}', 'AdminController@deactivateEntry')->name('set.deactivate');

Route::get('/dashboard/admin/getactive', 'AdminController@getActive')->name('get.active');

Route::get('/dashboard/livescoring', 'LiveScoringController@index')->name('livescoring');

Route::post('/dashboard/livescoring/check', 'LiveScoringController@checkActive')->name('livescoring.checkActive');

Route::get('/dashboard/ranking', 'RankingController@index')->name('ranking');

Route::get('/dashboard/ranking/results', 'RankingController@index')->name('ranking.form'); 

Route::post('/dashboard/ranking/results', 'RankingController@show')->name('ranking.show'); 

Route::post('/dashboard/ranking/export', 'RankingController@export')->name('ranking.export');

Route::get('/dashboard/categories/', 'CategoriesController@index')->name('categories');

Route::post('/dashboard/categories/', 'CategoriesController@save')->name('categories.save');

Route::post('/dashboard/categories/add', 'CategoriesController@add')->name('categories.add');

Route::post('/dashboard/categories/delete', 'CategoriesController@delete')->name('categories.delete');

Route::get('/dashboard/categories/{id}/edit', 'CategoriesController@edit')->name('category.edit');

Route::get('/dashboard/categories/{id}/delete', 'CategoriesController@confirmDelete')->name('categories.deleteConfirm');

Route::post('/dashboard/categories/import', function() {
	Excel::import(new CategoriesImport, request()->file('file'));

	return redirect()->back()->with('success','Data Imported Successfully.');
})->name('categories.import');

Route::post('/dashboard/scoring/upload', 'UploadController@uploadFile')->name('upload.recording');

Route::get('/dashboard/entries/', 'EntriesController@index')->name('entries');

Route::post('/dashboard/entries/', 'EntriesController@store')->name('entries.save');

Route::post('/dashboard/entries/add', 'EntriesController@create')->name('entries.add');

Route::post('/dashboard/entries/delete', 'EntriesController@destroy')->name('entries.delete');

Route::get('/dashboard/entries/{id}/edit', 'EntriesController@edit')->name('entries.edit');

Route::get('/dashboard/entries/{id}/delete', 'EntriesController@confirmDelete')->name('entries.deleteConfirm');

Route::post('/dashboard/entries/import', function() {
	Excel::import(new EntriesImport, request()->file('file'));

	return redirect()->back()->with('success','Data Imported Successfully.');
})->name('entries.import');

Route::get('/dashboard/schools','SchoolsController@index')->name('schools');

Route::post('/dashboard/schools/', 'SchoolsController@store')->name('schools.save');

Route::post('/dashboard/schools/add', 'SchoolsController@create')->name('schools.add');

Route::get('/dashboard/schools/{id}/edit', 'SchoolsController@edit')->name('schools.edit');

Route::post('/dashboard/schools/delete', 'SchoolsController@destroy')->name('schools.delete');

Route::get('/dashboard/schools/{id}/delete', 'SchoolsController@confirmDelete')->name('schools.deleteConfirm');

Route::post('/dashboard/schools/import', function() {
	Excel::import(new SchoolsImport, request()->file('file'));

	return redirect()->back()->with('success','Data Imported Successfully.');
})->name('schools.import');

Route::get('/dashboard/recordings', 'RecordingsController@index')->name('recordings');

Route::get('/dashboard/recordings/convert', 'RecordingsController@convert')->name('convert');
