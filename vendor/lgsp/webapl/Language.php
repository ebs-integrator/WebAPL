<?php 
 
 /**
  * 
  * CMS Platform WebAPL 1.0 is a free open source software for creating and managing
  * a web site for Local Public Administration institutions. The platform was
  * developed at the initiative and on a concept of USAID Local Government Support
  * Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
  * The opinions expressed on the website belong to their authors and do not
  * necessarily reflect the views of the United States Agency for International
  * Development (USAID) or the US Government.
  * 
  * This program is free software: you can redistribute it and/or modify it under
  * the terms of the GNU General Public License as published by the Free Software
  * Foundation, either version 3 of the License, or any later version.
  * This program is distributed in the hope that it will be useful, but WITHOUT ANY
  * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  * PARTICULAR PURPOSE. See the GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License along with
  * this program. If not, you can read the copy of GNU General Public License in
  * English here: <http://www.gnu.org/licenses/>.
  * 
  * For more details about CMS WebAPL 1.0 please contact Enterprise Business
  * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
  * email to office@ebs.md 
  * 
  **/
 


namespace WebAPL;

use DB,
    Exception,
    Session,
    Input,
    Request;

class Language {

    protected static $id = 1;
    protected static $list = array();
    protected static $language = null;

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        $list = DB::table('apl_lang')->get();
        foreach ($list as $lang) {
            self::$list[$lang->id] = $lang;
        }

        self::_init_language();

        self::loadVars();
    }

    /**
     * Init current language
     * @throws Exception
     */
    private static function _init_language() {
        $lang = Request::segment(1);

        if (!self::inList($lang)) {
            $lang = Session::get('lang');
        }

        self::setLanguage($lang);
    }

    /**
     * Get laguages list
     * @return array
     */
    public static function getList() {
        return self::$list;
    }

    /**
     * Get current language id
     * @return int
     */
    public static function getId() {
        return self::$id;
    }

    /**
     * 
     * @param string $ext
     * @return boolean
     */
    public static function inList($ext) {
        $inList = false;

        foreach (static::$list as $lang) {
            if ($ext == $lang->ext) {
                $inList = true;
            }
        }

        return $inList;
    }

    /**
     * Get current language record
     * @param int $lang_id
     * @return lang record
     */
    public static function getItem($lang_id = 0) {
        $lang_id = $lang_id ? $lang_id : self::$id;

        if (isset(self::$list[$lang_id])) {
            return self::$list[$lang_id];
        } else {
            return false;
        }
    }

    /**
     * Get current language extension
     * @return string[2]
     */
    public static function ext() {
        if (isset(self::$language->ext)) {
            return self::$language->ext;
        } else {
            self::_init_language();
            return self::ext();
        }
    }

    /**
     * Get url with language extension
     * @param string $path
     * @return string
     */
    public static function url($path = '') {
        return url(self::ext() . '/' . $path);
    }

    /**
     * Set language
     * @param string[2] $ext
     * @throws Exception
     */
    public static function setLanguage($ext) {
        $language = DB::table('apl_lang')->where('ext', $ext)->first();
        if (!$language) {
            $language = DB::table('apl_lang')->where('id', '=', \SettingsModel::one('default_language'))->first();
        }
        
        if (!$language) {
            $language = DB::table('apl_lang')->first();
        }

        if ($language) {
            self::$language = $language;
            self::$id = $language->id;
            Session::put('lang', self::ext());
        } else {
            throw new Exception("Available language not found");
        }
    }

    /**
     * Get var
     * @param string $key
     * @return string
     */
    public static function getVar($key) {
        return isset(static::$vars[$key]) ? static::$vars[$key] : '';
    }

    protected static $vars = [];

    /**
     * Load Vars
     */
    protected static function loadVars() {
        $vars = \VarModel::prepareQuery()->select(\VarModel::getField('key'), \VarLangModel::getField('value'))->get();

        $tmpv = array();

        foreach ($vars as $var) {
            $tmpv[$var->key] = $var->value;
        }

        static::$vars = $tmpv;
    }

}
