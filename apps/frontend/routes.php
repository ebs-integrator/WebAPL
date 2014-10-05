<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/install/uninstalled')) {
    Event::fire('APL.install.run');
    return;
}

Event::fire('APL.modules.load');

Route::get('/', function () {
    return Redirect::to(Core\APL\Language::ext());
});

Route::group(array('prefix' => Core\APL\Language::ext()), function() {
    Route::get('/', 'PageController@home');
    Route::get('page/{furi}', 'PageController@route')->where(array('furi' => '[A-Za-z0-9-\/]+'));
    //Route::get('home/{furi}', 'PageController@route')->where(array('furi' => '[A-Za-z0-9-]+'));
    
    Route::get('search', 'SearchController@results');
    Route::get('topost/{id}', 'SearchController@topost');
    
    Route::any('rss', array('PostResources', 'rssPage'));
});


Route::post('contact/submit', array('PostResources', 'contactSubmit'));
Route::post('contact/topsubmit', array('PostResources', 'contactTopSubmit'));


Route::get('language/{ext}', 'PageController@changeLanguage')->where(array('ext' => '[a-z]{0,2}'));
Route::get('language/{ext}/{id}', 'PageController@changeLanguage')->where(array('ext' => '[a-z]{0,2}'));

Route::get('markup', function () {
    return View::make('sections.show_page');
}); 
Route::get('page/markup/{uri}', 'HomeController@page_markup')->where(array('uri' => '[A-Za-z0-9-]+'));
Route::get('home/markup/{uri}', 'HomeController@home_markup')->where(array('uri' => '[A-Za-z0-9-]+'));
