<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/install/uninstalled')) {
    return Route::get('/', function () {
        return Illuminate\Support\Facades\Redirect::to('../');
    });
}

Event::fire('APL.modules.load');

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
Route::controller('user', 'UserController');
Route::controller('settings', 'SettingsController');
Route::controller('template', 'TemplateController');

Route::get('/', 'HomeController@showDashboard');


