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

    public function postSearch() {
        $query = Input::get('varname');

        $list = VarLangModel::where(VarLangModel::getField('value'), 'like', "%{$query}%")->get();

        $count = count($list);

        if ($count == 0) {
            return \Illuminate\Support\Facades\Redirect::back()->with('searchfail', 1);
        } elseif ($count == 1) {
            $item = $list[0];
            return \Illuminate\Support\Facades\Redirect::to('var/index/' . $item->var_key);
        } else {
            return \Illuminate\Support\Facades\Redirect::back()->with('searchfail', 0)->with('searchresult', $list->toArray());
        }
    }

    public function postCreate() {
        $parent_key = Input::get('parent_key');
        $var_langs = Input::get('text');
        $key = VarModel::uniqKey(Input::get('key'), Input::get('text.' . (\Core\APL\Language::getId())));

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

    public function getExport() {

        $buffer = "";

        $vars = VarModel::all();

        $num = 0;

        $vlang_ids = array();

        foreach ($vars as $var) {
            $langs = VarLangModel::where('var_key', $var->key)->get();
            foreach ($langs as $vlang) {
                $langname = Core\APL\Language::getItem($vlang->lang_id)->name;
                $buffer .= "{$vlang->id},{$langname},\"{$vlang->value}\"\n";

                $vlang_ids[] = $vlang->id;

                $num++;
            }
            $buffer .= "\n";
        }

        $buffer .= "{$num}\n";

        //var_dump(count($vlang_ids), VarLangModel::whereNotIn('id', $vlang_ids)->get());
        //return [];

        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=Customers_Export.csv');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM

        return $buffer;
    }

    public function getImport() {
        $xsdstring = $_SERVER['DOCUMENT_ROOT'] . "/vars.xml";
        die;
        $excel = new XML2003Parser($xsdstring);

        $table = $excel->getTableData();

        foreach ($table["table_contents"] as $row) {
            if (isset($row["row_contents"][2]) && isset($row["row_contents"][0])) {
                $id = $row["row_contents"][0]['value'];
                if ($id) {
                    $value = $row["row_contents"][2]['value'];
                    $varlang = VarLangModel::find($id);
                    if ($varlang) {
                        $varlang->value = $value;
                        $varlang->save();
                    } else {
                        echo "undefined {$id} <br>";
                    }
                } else {
                    echo "clear<br>";
                }
            }
        }
        return [];
    }

}
