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



Route::get('page', 'HomeController@showPage');

Route::controller('auth', 'AuthController');
Route::controller('module', 'ModuleController');

Route::post('uploader/start', 'UploaderController@start');
Route::post('uploader/add', 'UploaderController@add');
Route::post('uploader/filelist', 'UploaderController@filelist');
Route::post('uploader/delete', 'UploaderController@delete');
Route::post('uploader/editname', 'UploaderController@editname');

Route::controller('home', 'HomeController');
Route::controller('menu', 'MenuController');
Route::controller('page', 'PageController');
Route::controller('feed', 'FeedController');
Route::controller('log', 'LogController');
Route::controller('var', 'VarController');

Route::get('/', 'HomeController@showDashboard');


