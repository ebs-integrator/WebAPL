<?php

namespace Core\APL;

class Actions {

    static protected $actions = array();

    public static function register($tag, $function, $priority = 1) {
        self::$actions[$tag][$priority][] = $function;

        ksort(self::$actions[$tag]);
    }

    public static function call($tag) {
        $arguments = func_get_args();
        unset($arguments[0]);

        if (self::check($tag)) {
            $actions = self::$actions[$tag];

            foreach ($actions as $action) {
                foreach ($action as $function) {
                    call_user_func_array($function, $arguments);
                }
            }
        }
    }

    public static function check($tag) {
        return isset(self::$actions[$tag]);
    }
    
    // create get route for action
    public static function get($tag, $function) {
        \Route::get($tag, $function);
    }
    
    // create post route for action
    public static function post($tag, $function) {
        \Route::post($tag, $function);
    }

}
