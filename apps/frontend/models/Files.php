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
