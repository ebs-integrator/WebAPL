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
class SettingsModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_setting';
    protected $primaryKey = 'key';
    public $timestamps = false;
    protected static $settings = array();

    public static function getAll() {
        if (self::$settings) {
            return self::$settings;
        }

        $list = SettingsModel::all();

        $return = array();

        foreach ($list as $item) {
            $return[$item->key] = $item->value;
        }

        self::$settings = $return;

        return $return;
    }

    public static function one($key) {
        $list = self::getAll();
        return isset($list[$key]) ? $list[$key] : false;
    }

    public static function put($key, $value) {
        $set = SettingsModel::where('key', $key)->first();
        if ($set) {
            SettingsModel::where('key', $key)->update(array(
                'value' => $value
            ));
        } else {
            SettingsModel::insert(array(
                'value' => $value,
                'key' => $key
            ));
        }
    }

}
