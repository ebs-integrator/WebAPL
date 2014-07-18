<?php

namespace Core\APL;

class Language {

    protected static $id = 1;
    
    protected static $list  = array();
    
    public static function __init() {
        self::$list = \DB::table('apl_lang')->get();
    }
    
    public static function getList() {
        return self::$list;
    }
    
    public static function getId() {
        return self::$id;
    }
}