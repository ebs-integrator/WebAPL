<?php 
 
 /**
  * 
  * CMS Platform WebAPL 1.0 is a free open source software for creating and managing
  * a web site for Local Public Administration institutions. The platform was
  * developed at the initiative and on a concept of USAID Local Government Support
  * Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
  * The opinions expressed on the website belong to their authors and do not
  * necessarily reflect the views of the United States Agency for International
  * Development (USAID) or the US Government.
  * 
  * This program is free software: you can redistribute it and/or modify it under
  * the terms of the GNU General Public License as published by the Free Software
  * Foundation, either version 3 of the License, or any later version.
  * This program is distributed in the hope that it will be useful, but WITHOUT ANY
  * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  * PARTICULAR PURPOSE. See the GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License along with
  * this program. If not, you can read the copy of GNU General Public License in
  * English here: <http://www.gnu.org/licenses/>.
  * 
  * For more details about CMS WebAPL 1.0 please contact Enterprise Business
  * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
  * email to office@ebs.md 
  * 
  **/
 



ClassLoader::addDirectories(array(
    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',
));

//Log::useFiles(storage_path() . '/logs/laravel.log');

App::error(function(Exception $exception, $code) {
    Log::error($exception);

    if (Config::get('app.debug') === true) {
        return null;
    }
    
    $page_property = false;

    $ecode = $exception->getCode();
    $pageCode = in_array($ecode, [404]) ? $ecode : $code;

    if ($pageCode == 404) {
        $page_property = 'error_404';
    } elseif ($pageCode >= 500) {
        $page_property = 'error_404';
    } else {
        $page_property = 'error_404';
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
