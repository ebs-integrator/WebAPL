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

use Exception;

class Modules {

    protected static $instances = array();

    /**
     * Initialize module
     * This function is called on bootstrap
     */
    public static function __init() {
        
    }

    /**
     * Create module instange, and save
     * @param string $tag
     * @throws Exception
     */
    public static function addInstance($tag) {
        $realName = self::getRealModuleName($tag);
        if (class_exists($realName)) {
            self::$instances[$tag] = new $realName;
        } else {
            throw new Exception("Class '{$realName}' not found");
        }
    }

    /**
     * Get instance
     * @param string $tag
     * @return Object
     */
    public static function getInstance($tag) {
        if (self::checkInstance($tag)) {
            return self::$instances[$tag];
        } else {
            self::addInstance($tag);
            return self::getInstance($tag);
        }
    }

    /**
     * Verify if instace exist
     * @param string $tag
     * @return boolean
     */
    public static function checkInstance($tag) {
        return isset(self::$instances[$tag]);
    }

    /**
     * Get real class name
     * @param string $tag
     * @return string
     */
    protected static function getRealModuleName($tag) {
        return "WebAPL\Modules\\{$tag}";
    }
    
    

}
