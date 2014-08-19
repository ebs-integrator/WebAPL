<?php

/**
 * 
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL;

class Language {

    protected static $id = 1;
    protected static $list = array();

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        $list = \DB::table('apl_lang')->get();
        foreach ($list as $lang) {
            self::$list[$lang->id] = $lang;
        }
    }

    /**
     * Get laguages list
     * @return array
     */
    public static function getList() {
        return self::$list;
    }

    /**
     * Get current language id
     * @return int
     */
    public static function getId() {
        return self::$id;
    }

    /**
     * Get current language record
     * @param int $lang_id
     * @return lang record
     */
    public static function getItem($lang_id = 0) {
        $lang_id = $lang_id ? $lang_id : self::$id;

        if (isset(self::$list[$lang_id])) {
            return self::$list[$lang_id];
        } else {
            return false;
        }
    }

}