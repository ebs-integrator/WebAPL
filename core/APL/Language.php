<?php

namespace Core\APL;

class Language {

    protected static $id = 1;
    
    protected static $list  = array();
    
    public static function __init() {
        $list = \DB::table('apl_lang')->get();
        foreach ($list as $lang) {
            self::$list[$lang->id] = $lang;
        }
    }
    
    public static function getList() {
        return self::$list;
    }
    
    public static function getId() {
        return self::$id;
    }
    
    public static function getItem($lang_id = 0) {
        $lang_id = $lang_id ? $lang_id : self::$id;
        
        if (isset(self::$list[$lang_id])) {
            return self::$list[$lang_id];
        } else {
            return false;
        }
    }
}