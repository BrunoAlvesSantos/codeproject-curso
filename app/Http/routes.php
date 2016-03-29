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
    return view('app');
});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware'=>'oauth'], function(){
    // Client Routes
    Route::resource('client', 'ClientController',['except' => ['create', 'edit']]);

    Route::resource('project.member', 'ProjectMemberController', ['except' => ['create', 'edit', 'update']]);

    // Route::group(['middleware'=>'CheckProjectOwner'], function() {
    Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
    //});

    // Project Routes
    Route::group(['middleware' => 'check.project.permission', 'prefix' =>'project'], function () {

        // Project Notes Routes
        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
        Route::post('{id}/note', 'ProjectNoteController@store');
        Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
        Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');

        // Project File
        Route::get('{id}/file', 'ProjectFileController@index');
        Route::get('{id}/file/{fileId}', 'ProjectFileController@show');
        Route::get('{id}/file/{fileId}/download', 'ProjectFileController@showFile');
        Route::post('{id}/file', 'ProjectFileController@store');
        Route::put('{id}/file/{fileId}', 'ProjectFileController@update');
        Route::delete('{id}/file/{fileId}', 'ProjectFileController@destroy');

        // Project Tasks Routes
        Route::get('{id}/task', 'ProjectTaskController@index');
        Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
        Route::post('{id}/task', 'ProjectTaskController@store');
        Route::put('{id}/task/{taskId}', 'ProjectTaskController@update');
        Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');

        Route::get('{id}/members', 'ProjectMemberController@members');

    });

    Route::get('user/authenticated', 'UserController@authenticated');
    Route::resource('user', 'UserController', ['except' => ['create', 'edit']]);

});
