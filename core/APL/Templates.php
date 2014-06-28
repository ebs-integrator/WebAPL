<?php

namespace Core\APL;

class Templates {
    
    protected static $template = 'Default';
    
    public static function getCurrent() {
        return self::$template;
    }
    
    public static function setTemplate($template) {
        self::$template = $template;
    }
    
    public static function path($path = '') {
        return "/apps/" . APP_FOLDER . "/views/templates/" . self::$template . "/" . $path;
    }
}
