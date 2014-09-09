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

Event::fire('APL.modules.load');

Route::get('/', function () {
    return Redirect::to(Core\APL\Language::ext());
});

Route::group(array('prefix' => Core\APL\Language::ext()), function() {
    Route::get('/', 'PageController@home');
    Route::get('page/{furi}', 'PageController@route')->where(array('furi' => '[A-Za-z0-9-\/]+'));
    Route::get('home/{furi}', 'PageController@route')->where(array('furi' => '[A-Za-z0-9-]+'));
});

Route::get('language/{ext}', function ($ext) {
    Core\APL\Language::setLanguage($ext);
    return Redirect::to(Core\APL\Language::ext());
})->where(array('ext' => '[a-z]{0,2}'));

Route::get('markup', function () {
    return View::make('sections.show_page');
});
Route::get('page/markup/{uri}', 'HomeController@page_markup')->where(array('uri' => '[A-Za-z0-9-]+'));
Route::get('home/markup/{uri}', 'HomeController@home_markup')->where(array('uri' => '[A-Za-z0-9-]+'));
