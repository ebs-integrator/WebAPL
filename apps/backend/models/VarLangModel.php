<?php

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
