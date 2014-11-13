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
