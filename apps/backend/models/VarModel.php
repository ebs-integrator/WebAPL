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
class VarModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_var';
    public $timestamps = false;

    public static function prepareQuery() {
        return VarModel::join(VarLangModel::getTableName(), VarLangModel::getField('var_key'), '=', VarModel::getField('key'))
                        ->where(VarLangModel::getField('lang_id'), \WebAPL\Language::getId());
    }

    public static function withParent($var_key) {
        $list = VarModel::prepareQuery()
                ->where(VarModel::getField('parent_key'), $var_key)
                ->get();
        foreach ($list as &$item) {
            $item['num_vars'] = VarModel::prepareQuery()->where(VarModel::getField('parent_key'), $item->key)->count();
        }
        return $list;
    }

    public static function getParents($key) {
        $list = array();
        while ($key) {
            $item = VarModel::prepareQuery()->where('key', $key)->first();
            if ($item) {
                $list[] = $item;
                $key = $item->parent_key;
            } else {
                $key = '';
            }
        }
        return $list;
    }

    public static function uniqKey($key, $str) {
        if ($key) {
            $key = urigen($key);
        } else {
            $key = urigen($str);
        }

        $count = VarModel::where("key", "like", "{$key}%")->count();

        if ($count) {
            return $key . '-' . $count;
        } else {
            return $key;
        }
    }

}
