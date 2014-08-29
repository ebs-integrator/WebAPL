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
    protected static $view_mods = array(
        'page' => array(
            'posturi_vacante' => array(
                'name' => 'Lista de posturi vacante',
                'function' => array('PageView', 'posturiVacante')
            ),
            'promisiuni_primar' => array(
                'name' => 'Lista de promisiuni a primarului',
                'function' => array('PageView', 'promisesMod')
            ),
            'locations_list' => array(
                'name' => 'Lista cu locatii',
                'function' => array('PageView', 'locationsList')
            ),
            'accordion_list' => array(
                'name' => 'Lista acordion',
                'function' => array('PageView', 'accordionList')
            )
        )
    );
    
    protected static $breadcrumbs = array();

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

        if (isset(self::$module) && self::$module) {
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

    /**
     * 
     * 
     * 
     *   VIEW METHODS
     *   functions like Actions component
     * 
     * 
     * 
     */

    /**
     * Register new method
     * @param string $section
     * @param string $tag
     * @param string $name
     * @param mixed $function
     * @param boolean $override
     * @throws Exception
     */
    public static function registerViewMethod($section, $tag, $name, $function, $override = false) {
        if (self::checkViewMethod($section, $tag) && !$override) {
            throw new Exception("Override view method '{$tag}' from '{$section}'");
        } else {
            self::$view_mods[$section][$tag] = array(
                'name' => $name,
                'function' => $function
            );
        }
    }

    /**
     * delete view method
     * @param string $fromSection
     * @param string $tag
     */
    public static function dropViewMethod($fromSection, $tag) {
        unset(self::$view_mods[$fromSection][$tag]);
    }

    /**
     * Verify if exist view method
     * @param string $section
     * @param string $tag
     * @return boolean
     */
    public static function checkViewMethod($section, $tag) {
        return isset(self::$view_mods[$section][$tag]) && $tag && $section;
    }

    /**
     * Call view Method
     * @param string $section
     * @param string $tag
     * @param string $parameters
     * @return mixed
     * @throws Exception
     */
    public static function callViewMethod($section, $tag, $parameters = array()) {
        if (self::checkViewMethod($section, $tag)) {
            return call_user_func_array(self::$view_mods[$section][$tag]['function'], $parameters);
        } else {
            throw new Exception("Undefined view method '{$tag}' in '{$section}'");
        }
    }

    /**
     * get list of section methods
     * @param string $section
     * @return array
     */
    public static function getViewMethodList($section) {
        if (isset(self::$view_mods[$section])) {
            return self::$view_mods[$section];
        } else {
            return array();
        }
    }

    /**
     * 
     * 
     *   END VIEW METHODS
     * 
     * 
     */
    
    
    
    /**
     * 
     *   Breadcrumb
     * 
     */
    
    public static function addBreadCrumb($url, $name) {
        self::$breadcrumbs[] = array(
            'name' => $name,
            'url' => $url
        );
    }
    
    public static function getBreadCrumbs() {
        return self::$breadcrumbs;
    }
}
