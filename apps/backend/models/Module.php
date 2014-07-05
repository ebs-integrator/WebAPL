<?php

class Module extends Eloquent {

    protected $table = 'apl_module';
    public $timestamps = false;

    public static function allKey() {
        $list = Module::all();

        $modulesKey = array();
        foreach ($list as $item) {
            $modulesKey[$item->extension] = $item;
        }

        return $modulesKey;
    }

    public static function files() {
        $files = glob(app_path("modules/*.php"));

        $module_files = array();
        foreach ($files as $file) {
            $module = new stdClass();
            $module->path = $file;
            $module->name = basename($file, ".php");
            $module->title = ucwords(basename($file, ".php"));
            $module_files[] = $module;
        }

        return $module_files;
    }

    public static function changeState($id, $state) {
        $module = Module::find($id);
        $module->enabled = $state;
        $module->save();
    }

}
