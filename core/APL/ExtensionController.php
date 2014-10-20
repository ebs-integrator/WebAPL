<?php
/**
 * 
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL;

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
