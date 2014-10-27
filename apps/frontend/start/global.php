<?php

ClassLoader::addDirectories(array(
    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',
));

//Log::useFiles(storage_path() . '/logs/laravel.log');

App::error(function(Exception $exception, $code) {
    Log::error($exception);

    $page_property = false;

    $ecode = $exception->getCode();
    $pageCode = in_array($ecode, [404]) ? $ecode : $code;

    if ($pageCode == 404) {
        $page_property = 'error_404';
    } elseif ($pageCode >= 500) {
        //$page_property = 'error_500';
    } else {
        //$page_property = 'error_other';
    }

    if ($page_property) {
        Post::$taxonomy = 1;
        $page = PostProperty::postWithProperty('error_404');
        if ($page) {
            $uri = Post::getFullURI($page->id, false);
            $contents = App::make('PageController')->route($uri);
            return Response::make($contents, $pageCode);
        }
    }

    //return "Undefined error!";
});

$APLExtensions = array(
    'Modules', 'Shortcodes', 'Template', 'Language', 'ExtensionController'
);

Event::listen('APL.core.load', function() use ($APLExtensions) {
    ClassLoader::addDirectories(base_path() . '/core/APL/');

    foreach ($APLExtensions as $Extension) {
        if (!ClassLoader::load($Extension)) {
            throw new Exception("'{$Extension}' load failed!");
        }
    }
});

Event::listen('APL.core.prepare', function () use ($APLExtensions) {
    foreach ($APLExtensions as $Extension) {
        $full_class = "Core\APL\\" . $Extension;
        $full_class::__init();
        class_alias($full_class, $Extension);
    }
});

Event::listen('APL.website.check', function () {
    if (Input::get('is_admin')) {
        Session::put('is_admin', true);
    }

    Session::put('in_maintenance', !SettingsModel::one('website_on') && !Session::get('is_admin'));
});

Event::listen('APL.modules.load', function() {
    Event::fire('APL.core.load');
    Event::fire('APL.core.prepare');
    Event::fire('APL.website.check');

    Event::fire('APL.modules.beforeload');

    Module::where('enabled', '1')->get()->each(function($module) {
        ClassLoader::addDirectories(app_path() . '/modules/' . $module->extension . '/');
        ClassLoader::load($module->extension);
        Modules::addInstance($module->extension);
    });

    Event::fire('APL.modules.afterload');
});

Event::listen('APL.install.check', function () {
    return file_exists($_SERVER['DOCUMENT_ROOT'] . '/install/uninstalled');
});

Event::listen('APL.install.run', function () {
    Event::fire('APL.core.load');

    ClassLoader::addDirectories(base_path() . '/install/');

    View::addNamespace('install', base_path() . '/install/views');

    Route::get('/', 'InstallController@getIndex');
    Route::controller('install', 'InstallController');
});

App::before(function() {
    
});

App::down(function() {
    return Response::make("Be right back!", 503);
});


require app_path() . '/filters.php';
