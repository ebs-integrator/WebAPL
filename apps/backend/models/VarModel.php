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
 
class VarModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_var';
    public $timestamps = false;

    public static function prepareQuery() {
        return VarModel::join(VarLangModel::getTableName(), VarLangModel::getField('var_key'), '=', VarModel::getField('key'))
                        ->select(VarLangModel::getField('*'), DB::raw(VarModel::getField('id')." as vid"), VarModel::getField('parent_key'), VarModel::getField('key')) 
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
