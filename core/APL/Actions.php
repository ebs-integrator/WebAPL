<?php

/**
 * 
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL;

use Route;

class Actions {

    static protected $actions = array();

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        
    }

    /**
     * Register new action
     * @param string $tag
     * @param object $function
     * @param int $priority
     */
    public static function register($tag, $function, $priority = 1) {
        self::$actions[$tag][$priority][] = $function;

        ksort(self::$actions[$tag]);
    }

    /**
     * Call all actions with $tag name
     * @param string $tag
     */
    public static function call($tag) {
        $arguments = func_get_args();
        // drop parameter $tag
        unset($arguments[0]);

        if (self::check($tag)) {
            $actions = self::$actions[$tag];

            foreach ($actions as $action) {
                foreach ($action as $function) {
                    $output = call_user_func_array($function, $arguments);
                    if ($output) {
                        echo $output;
                    }
                }
            }
        }
    }

    /**
     * Verify if exist actions with $tag name
     * @param string $tag
     * @return bool
     */
    public static function check($tag) {
        return isset(self::$actions[$tag]);
    }

    /**
     * 
     * @param string $tag
     * @param object $function
     */
    public static function get($tag, $function) {
        return Route::get($tag, $function);
    }

    /**
     * 
     * @param string $tag
     * @param object $function
     */
    public static function post($tag, $function) {
        return Route::post($tag, $function);
    }

    public static function toAscii($str, $replace = array(), $delimiter = '-') {
        setlocale(LC_ALL, 'en_US.UTF8');
        if (!empty($replace)) {
            $str = str_replace((array) $replace, ' ', $str);
        }

        $clean = preg_replace(array('/Ä/', '/Ö/', '/Ü/', '/ä/', '/ö/', '/ü/'), array('Ae', 'Oe', 'Ue', 'ae', 'oe', 'ue'), $str);
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

}
