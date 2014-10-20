<?php

class Files extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_file';
    public $timestamps = false;
    public static $default_accept_extensions = array(
        'jpg',
        'png',
        'jpeg'
    );
    // mecanic cache
    private static $cache = array();

    public static function file_list($module_name, $module_id) {
        $file_key = sha1($module_name . $module_id . 'm');
        if (isset(static::$cache[$file_key])) {
            return static::$cache[$file_key];
        } else {
            return static::$cache[$file_key] = Files::where('module_name', $module_name)->where('module_id', intval($module_id))->remember(SettingsModel::one('cachelife'))->get();
        }
    }

    public static function getfile($module_name, $module_id) {
        $file_key = sha1($module_name . $module_id . 'o');
        if (isset(static::$cache[$file_key])) {
            return static::$cache[$file_key];
        } else {
            return static::$cache[$file_key] = Files::where('module_name', $module_name)->where('module_id', intval($module_id))->remember(SettingsModel::one('cachelife'))->first();
        }
    }

    public static function extract($module_name, $module_id, $property) {
        $file = Files::getfile($module_name, $module_id);
        if (isset($file[$property]) && $file[$property]) {
            return $file[$property];
        } else {
            return false;
        }
    }

}
