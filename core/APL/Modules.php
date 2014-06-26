<?php

namespace Core\APL;

class Modules {

    protected static $instances = array();

    public static function addInstance($tag) {
        $realName = self::getRealModuleName($tag);
        if (class_exists($realName)) {
            self::$instances[$tag] = new $realName;
        } else {
            throw new \Exception("Class '{$realName}' not found");
        }
    }

    public static function getInstance($tag) {
        if (self::checkInstance($tag)) {
            return self::$instances[$tag];
        } else {
            self::addInstance($tag);
            return self::getInstance($tag);
        }
    }

    public static function checkInstance($tag) {
        return isset(self::$instances[$tag]);
    }

    protected static function getRealModuleName($tag) {
        return "Core\APL\Modules\\{$tag}";
    }

}
