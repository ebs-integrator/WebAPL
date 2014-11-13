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
class VarLangModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_var_lang';
    public $timestamps = false;

    public static function addLang($lang_id) {
        $vars = VarModel::all();
        foreach ($vars as $item) {
            $var_lang = new VarLangModel;
            $var_lang->lang_id = $lang_id;
            $var_lang->var_key = $item->key;
            $var_lang->save();
        }
    }

    public static function removeLang($lang_id) {
        VarLangModel::where('lang_id', $lang_id)->delete();
    }

}
