<?php

/**
 *
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */
class VarController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';

    public function getIndex($var_key = '') {

        $this->data['var'] = VarModel::prepareQuery()->where('key', $var_key)->first();
        if ($this->data['var'] || $var_key === '') {
            $this->data['var_key'] = $var_key;
            $this->data['var_list'] = VarModel::withParent($var_key);

            if ($this->data['var']) {
                $this->data['var_parents'] = VarModel::getParents($this->data['var']->parent_key);
            } else {
                $this->data['var_parents'] = [];
            }

            $this->layout->content = View::make('sections.var.list', $this->data);
        } else {
            throw new Exception("Var not found '{$var_key}'");
        }
    }

    public function postCreate() {
        $parent_key = Input::get('parent_key');
        $var_langs = Input::get('text');
        $key = VarModel::uniqKey(Input::get('key'), Input::get('text.'.(\Core\APL\Language::getId())));
        
        $var = new VarModel;
        $var->key = $key;
        $var->parent_key = $parent_key;
        $var->save();

        foreach ($var_langs as $lang_id => $value) {
            $var_lang = new VarLangModel;
            $var_lang->var_key = $key;
            $var_lang->lang_id = $lang_id;
            $var_lang->value = $value;
            $var_lang->save();
        }

        Log::info("Created new var '{$key}'");
        
        return Redirect::back();
    }
    
    public function postEdit() {
        $id = Input::get('id');
        $value = Input::get('value');
        
        $vlang = VarLangModel::find($id);
        $vlang->value = $value;
        $vlang->save();
        
        return [];
    }

}
