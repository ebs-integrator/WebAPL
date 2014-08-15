<?php

namespace Core\APL;

use Log,
    DB,
    Auth,
    Request;

class ExtensionController extends \BaseController {

    public static function __init() {

        Log::listen(function($level, $message, $context) {
                    $user = Auth::user();
                    DB::table('apl_logs')->insert(array(
                        'level' => $level,
                        'message' => $message,
                        'user_id' => $user ? $user->id : 0,
                        'ip' => Request::getClientIp(),
                        'url' => Request::url()
                    ));
                });
    }

    public static function edit() {
        throw new Exception('Edit controller not defined');
    }

    public function loadClass($model, $module_name = '') {
        if (is_array($model)) {
            foreach ($model as $mod) {
                $this->loadClass($mod, $module_name);
            }
        } else {
            $defined_module_name = isset($this->module_name) ? $this->module_name : '';
            $module_name = $module_name ? $module_name : $defined_module_name;
            $module_path = '/modules/' . $module_name . '/models/';

            \ClassLoader::addDirectories(app_path($module_path));
            if (!\ClassLoader::load($model)) {
                throw new \Exception("Class '{$model}' not found in '{$module_path}'");
            }
        }
    }

}
