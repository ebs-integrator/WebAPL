<?php

namespace Core\APL;

class ExtensionController extends \BaseController {

    public static function __init() {
        
    }

    public static function edit() {
        throw new Exception('Edit controller not defined');
    }

    public function loadClass($model, $module_name = '') {
        $defined_module_name = isset($this->module_name) ? $this->module_name : '';
        $module_name = $module_name ? $module_name : $defined_module_name;
        $module_path = '/modules/' . $module_name . '/models/';
        
        \ClassLoader::addDirectories(app_path($module_path));
        if (!\ClassLoader::load($model)) {
            throw new \Exception("Class '{$model}' not found in '{$module_path}'");
        }
    }

}
