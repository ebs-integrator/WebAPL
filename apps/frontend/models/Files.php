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

    public static function file_list($module_name, $module_id) {
        return Files::where('module_name', $module_name)->where('module_id', intval($module_id))->get();
    }

    public static function getfile($module_name, $module_id) {
        return Files::where('module_name', $module_name)->where('module_id', intval($module_id))->first();
    }


}
