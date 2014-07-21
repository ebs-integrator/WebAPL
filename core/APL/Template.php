<?php

namespace Core\APL;

class Template {

    protected static $template = 'Default';
    protected static $module = null;

    public static function __init() {
        
    }

    public static function getCurrent() {
        return self::$template;
    }

    public static function preparePaths($paths = array()) {
        $paths = (array) $paths;

        if (isset(self::$module)) {
            $paths = array(
                app_path() . '/modules/' . self::$module . '/'
            );
        } else {
            foreach ($paths as &$path) {
                $path = $path . '/' . self::$template . '/';
            }
        }

        return $paths;
    }

    public static function setTemplate($template) {
        self::$template = $template;
    }

    public static function path($path = '') {
        return "/apps/" . APP_FOLDER . "/views/templates/" . self::$template . "/" . $path;
    }

    public static function moduleView($module, $view, $data = array()) {
        self::$module = $module;
        $data = \View::make($view, $data);
        self::$module = null;
        return $data;
    }

    public static function mainLayout() {
        return \View::make('layout.main');
    }

}
