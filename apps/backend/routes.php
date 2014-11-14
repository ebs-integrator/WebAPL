<?php

/**
 * 
 * CMS WebAPL 1.0. Platform is a free open source software for creating an managing
 * their full with CMS integrated CMS system
 * 
 * Copyright (C) 2014 Enterprise Business Solutions SRL
 * 
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with
 * this program.  If not, see <http://www.gnu.org/licenses/>.
 * You can read the copy of GNU General Public License in english here 
 * 
 * For more details about CMS WebAPL 1.0 please contact Enterprise Business
 * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
 * email to office@ebs.md 
 * 
 */


if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/install/uninstalled')) {
    return Route::get('/', function () {
        return Illuminate\Support\Facades\Redirect::to('../');
    });
}

Event::fire('APL.modules.load');

Route::get('page', 'HomeController@showPage');


Route::get('death', 'HomeController@getEmpty');

Route::controller('auth', 'AuthController');
Route::controller('module', 'ModuleController');

Route::post('uploader/start', 'UploaderController@start');
Route::post('uploader/add', 'UploaderController@add');
Route::post('uploader/filelist', 'UploaderController@filelist');
Route::post('uploader/delete', 'UploaderController@delete');
Route::post('uploader/editname', 'UploaderController@editname');
Route::get('filemanager', 'UploaderController@filemanager');

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


