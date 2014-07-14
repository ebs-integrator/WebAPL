<?php

class Menu extends Eloquent {

    protected $table = 'apl_menu';
    public static $ftable = 'apl_menu';
    public $timestamps = false;

    public static function insertArray($array) {
        DB::table(self::$ftable)->insert($array);
    }

    public static function updateArray($array, $where) {
        DB::table(self::$ftable)
                ->where('id', $where)
                ->update($array);
    }

}