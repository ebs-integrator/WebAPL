<?php

/**
 * 
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL;

use View;

class Template {

    protected static $template = 'Default';
    protected static $module = null;

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        
    }

    /**
     * Get current template name
     * @return string
     */
    public static function getCurrent() {
        return self::$template;
    }

    /**
     * 
     * @param array $paths
     * @return string
     */
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

    /**
     * Set template
     * @param string $template
     */
    public static function setTemplate($template) {
        self::$template = $template;
    }

    /**
     * 
     * @param string $path
     * @return string
     */
    public static function path($path = '') {
        return "/apps/" . APP_FOLDER . "/views/templates/" . self::$template . "/" . $path;
    }

    /**
     * Load view from module folder
     * @param string $module
     * @param string $view
     * @param mixed $data
     * @return View
     */
    public static function moduleView($module, $view, $data = array()) {
        self::$module = $module;
        $data = View::make($view, $data);
        self::$module = null;
        return $data;
    }

    /**
     * Get main layout
     * @return type
     */
    public static function mainLayout() {
        return View::make('layout.main');
    }

}
