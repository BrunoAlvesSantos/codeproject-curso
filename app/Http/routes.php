<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* Clients Routes */
Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');
Route::put('client/{id}', 'ClientController@update');
Route::get('client/{id}/edit', 'ClientController@edit');

/* Projects Routes */
Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::put('project/{id}', 'ProjectController@update');
Route::get('project/{id}/edit', 'ProjectController@edit');

/* ProjectNotes Routes */
Route::get('project/note', 'ProjectNoteController@index');
Route::post('project/note', 'ProjectNoteController@store');
Route::get('project/note/{id}', 'ProjectNoteController@show');
Route::delete('project/note/{id}', 'ProjectNoteController@destroy');
Route::put('project/note/{id}', 'ProjectNoteController@update');
Route::get('project/note/{id}/edit', 'ProjectNoteController@edit');