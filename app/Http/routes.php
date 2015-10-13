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

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

/* Client Routes */
Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');
Route::put('client/{id}', 'ClientController@update');

/* Project Routes */
Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::put('project/{id}', 'ProjectController@update');

/* Project Notes Routes */
Route::get('project/{id}/note', 'ProjectNoteController@index');
Route::post('project/{id}/note', 'ProjectNoteController@store');
Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');
Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');

/* Project Tasks Routes */
Route::get('project/{id}/task', 'ProjectTaskController@index');
Route::post('project/{id}/task', 'ProjectTaskController@store');
Route::get('project/{id}/task/{taskId}', 'ProjectTaskController@show');
Route::delete('project/{id}/task/{taskId}', 'ProjectTaskController@destroy');
Route::put('project/{id}/task/{taskId}', 'ProjectTaskController@update');

/* Project Members Routes */
Route::get('project/{id}/members', 'ProjectController@members');
Route::post('project/{id}/member', 'ProjectController@addMember');
Route::get('project/{id}/member/{userId}', 'ProjectController@isMember');
Route::delete('project/{id}/member/{userId}', 'ProjectController@removeMember');
