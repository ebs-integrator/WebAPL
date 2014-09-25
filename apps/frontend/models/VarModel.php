<?php

class VarModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_var';
    public $timestamps = false;

    public static function prepareQuery() {
        return VarModel::join(VarLangModel::getTableName(), VarLangModel::getField('var_key'), '=', VarModel::getField('key'))
                        ->where(VarLangModel::getField('lang_id'), \Core\APL\Language::getId())
                        ->select(VarLangModel::getField('*'));
    }

    public static function withParent($var_key) {
        $list = VarModel::prepareQuery()
                ->where(VarModel::getField('parent_key'), $var_key)
                ->get();
        foreach ($list as &$item) {
            $item['num_vars'] = VarModel::withParent($item->key)->count();
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

}
