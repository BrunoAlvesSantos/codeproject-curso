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

Route::group(['middleware'=>'oauth'], function(){
    // Client Routes
    Route::resource('client', 'ClientController',['except' => ['create', 'edit']]);

    // Route::group(['middleware'=>'CheckProjectOwner'], function() {
        Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);
    //});

    // Project Routes
    Route::group(['prefix' =>'project'], function () {

        // Project Notes Routes
        Route::get('{id}/note', 'ProjectNoteController@index');
        Route::post('{id}/note', 'ProjectNoteController@store');
        Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
        Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');
        Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');

        // Project Tasks Routes
        Route::get('{id}/task', 'ProjectTaskController@index');
        Route::post('{id}/task', 'ProjectTaskController@store');
        Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
        Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');
        Route::put('{id}/task/{taskId}', 'ProjectTaskController@update');

        // Project Members Routes
        Route::get('{id}/members', 'ProjectController@members');
        Route::post('{id}/member', 'ProjectController@addMember');
        Route::get('{id}/member/{userId}', 'ProjectController@isMember');
        Route::delete('{id}/member/{userId}', 'ProjectController@removeMember');

        Route::post('{id}/file','ProjectFileController@store');
        Route::delete('{id}/file','ProjectFileController@destroy');
    });

});
