<?php

/**
 * 
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL;

use Exception;

class Modules {

    protected static $instances = array();

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        
    }

    /**
     * Create module instange, and save
     * @param string $tag
     * @throws Exception
     */
    public static function addInstance($tag) {
        $realName = self::getRealModuleName($tag);
        if (class_exists($realName)) {
            self::$instances[$tag] = new $realName;
        } else {
            throw new Exception("Class '{$realName}' not found");
        }
    }

    /**
     * Get instance
     * @param string $tag
     * @return Object
     */
    public static function getInstance($tag) {
        if (self::checkInstance($tag)) {
            return self::$instances[$tag];
        } else {
            self::addInstance($tag);
            return self::getInstance($tag);
        }
    }

    /**
     * Verify if instace exist
     * @param string $tag
     * @return boolean
     */
    public static function checkInstance($tag) {
        return isset(self::$instances[$tag]);
    }

    /**
     * Get real class name
     * @param string $tag
     * @return string
     */
    protected static function getRealModuleName($tag) {
        return "Core\APL\Modules\\{$tag}";
    }
    
    

}
