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


ClassLoader::addDirectories(array(
    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',
));

App::error(function(Exception $exception, $code) {
    Log::error($exception);
});


$APLExtensions = array(
    'Modules', 'Shortcodes', 'Template', 'Language', 'ExtensionController'
);

Event::listen('APL.core.load', function() use ($APLExtensions) {
    ClassLoader::addDirectories(base_path() . '/vendor/lgsp/webapl/');

    foreach ($APLExtensions as $Extension) {
        if (!ClassLoader::load($Extension)) {
            throw new Exception("'{$Extension}' load failed!");
        }
    }
});

Event::listen('APL.core.prepare', function () use ($APLExtensions) {
    foreach ($APLExtensions as $Extension) {
        $full_class = "WebAPL\\" . $Extension;
        $full_class::__init();
        class_alias($full_class, $Extension);
    }
});


Event::listen('APL.modules.load', function() {
    Event::fire('APL.core.load');
    Event::fire('APL.core.prepare');

    Module::where('enabled', '1')->get()->each(function($module) {
        ClassLoader::addDirectories(app_path() . '/modules/' . $module->extension . '/');
        ClassLoader::load($module->extension);
        Modules::addInstance($module->extension);
    });
});

$clear_cache = FALSE;

Event::listen(['eloquent.sav*', 'eloquent.upd*', 'eloquent.del*', 'eloquent.creat*'], function () use (&$clear_cache) {
    $clear_cache = TRUE;
});

App::shutdown(function() use (&$clear_cache) {
    if ($clear_cache) {
        File::deleteDirectory($_SERVER['DOCUMENT_ROOT'] . '/apps/frontend/storage/cache/');
        @unlink($_SERVER['DOCUMENT_ROOT'] . '/apps/frontend/storage/meta/services.json');
        Cache::flush();
    }
});

App::before(function() {
    
});

App::down(function() {
    return Response::make("Be right back!", 503);
});

require app_path() . '/filters.php';
