<?php

/**
 * 
 * CMS WebAPL 1.0. Platform is a free open source software for creating an managing
 * their full with CMS integrated CMS system
 * 
 * Copyright (C) 2014 Enterprise Business Solutions SRL
 * 
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with
 * this program.  If not, see <http://www.gnu.org/licenses/>.
 * You can read the copy of GNU General Public License in english here 
 * 
 * For more details about CMS WebAPL 1.0 please contact Enterprise Business
 * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
 * email to office@ebs.md 
 * 
 */


namespace WebAPL;

use Log,
    DB,
    Auth,
    Request,
    ClassLoader,
    Exception;

class ExtensionController extends \BaseController {

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {

        Log::listen(function($level, $message, $context) {
                    $user = Auth::user();
                    DB::table('apl_logs')->where('event_date', '<', date("Y-m-d H:i:s", time() - 172800))->delete();
                    DB::table('apl_logs')->insert(array(
                        'level' => $level,
                        'message' => $message,
                        'user_id' => $user ? $user->id : 0,
                        'ip' => Request::getClientIp(),
                        'url' => Request::url()
                    ));
                });
    }

    /**
     * Load class from module directory with ClassLoader
     * @param mixed $model
     * @param string $module_name
     * @throws Exception
     */
    public function loadClass($model, $module_name = '') {
        if (is_array($model)) {
            // if is array of classes
            foreach ($model as $mod) {
                $this->loadClass($mod, $module_name);
            }
        } else {
            // if is single class
            $defined_module_name = isset($this->module_name) ? $this->module_name : '';
            $module_name = $module_name ? $module_name : $defined_module_name;
            $module_path = '/modules/' . $module_name . '/models/';

            ClassLoader::addDirectories(app_path($module_path));
            if (!ClassLoader::load($model)) {
                // if can't load this class
                throw new Exception("Class '{$model}' not found in '{$module_path}'");
            }
        }
    }

}
