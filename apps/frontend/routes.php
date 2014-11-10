<?php

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/install/uninstalled')) {
    Event::fire('APL.install.run');
    return;
}

Event::fire('APL.modules.load');

if (Session::get('in_maintenance')) {
    Route::any('{all}', function() {
        return View::make('sections.others.maintenance');
    })->where('all', '.*');
    return;
}

Route::get('/', 'PageController@home');

Route::group(array('prefix' => WebAPL\Language::ext()), function() {
    Route::get('/', 'PageController@home');
    Route::get('page/{furi}', 'PageController@route')->where(array('furi' => '[A-Za-z0-9-\/]+'));

    Route::get('search', 'SearchController@results');
    
    Route::get('topost/{id}', 'SearchController@topost');
    Route::get('topage/{uri}', 'SearchController@topage')->where(array('uri' => '[A-Za-z0-9_-]+'));
    Route::get('topropr/{uri}', 'SearchController@topropr')->where(array('uri' => '[A-Za-z0-9_-]+'));

    Route::any('rss', array('PostResources', 'rssPage'));
});

Route::post('contact/submit', array('PostResources', 'contactSubmit'));
Route::post('contact/topsubmit', array('PostResources', 'contactTopSubmit'));

Route::get('language/{ext}', 'PageController@changeLanguage')->where(array('ext' => '[a-z]{0,2}'));
Route::get('language/{ext}/{id}', 'PageController@changeLanguage')->where(array('ext' => '[a-z]{0,2}'));

Route::get('ccache', 'HomeController@clearcache');
