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
 * */
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
        User::onlyHas('var-edit');

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
        User::onlyHas('var-edit');

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
        User::onlyHas('var-create');

        $parent_key = Input::get('parent_key');
        $var_langs = Input::get('text');
        $key = VarModel::uniqKey(Input::get('key'), Input::get('text.' . (\WebAPL\Language::getId())));

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
        User::onlyHas('var-edit');

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
                $langname = WebAPL\Language::getItem($vlang->lang_id)->name;
                $buffer .= "{$vlang->id},{$langname},\"{$vlang->value}\"\n";

                $vlang_ids[] = $vlang->id;

                $num++;
            }
            $buffer .= "\n";
        }

        $buffer .= "{$num}\n";

        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=Customers_Export.csv');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM

        return $buffer;
    }

    public function getExportjson() {

        $buffer = [];

        $vars = VarModel::all();

        $except = [9,12,14,16,18,20,23,38,36,40,42,53];

        foreach ($vars as $var) {
            if (in_array($var->id, $except) == FALSE) {
                $langs = VarLangModel::where('var_key', $var->key)->get();
                foreach ($langs as $vlang) {
                    $buffer[] = [
                        'id' => $vlang->id,
                        'value' => $vlang->value,
                        'vid' => $var->id,
                        'key' => $var->key,
                        'parent_key' => $var->parent_key,
                        'lang_id' => $vlang->lang_id
                    ];
                }
            }
        }

        header('Content-Encoding: UTF-8');
        header('Content-type: application/json; charset=UTF-8');

        return ($buffer);
    }

    public function getImport() {
        return [];

        $xsdstring = $_SERVER['DOCUMENT_ROOT'] . "/vars.xml";
        $excel = new XML2003Parser($xsdstring);
        $table = $excel->getTableData();
        $ids = [];
        foreach ($table["table_contents"] as $row) {
            if (isset($row["row_contents"][2]) && isset($row["row_contents"][0])) {
                $id = $row["row_contents"][0]['value'];
                if ($id && in_array($id, [84]) === FALSE) {
                    $value = htmlspecialchars_decode($row["row_contents"][2]['value']);
                    $varlang = VarLangModel::find($id);
                    if ($varlang) {
                        $varlang->value = $value;

                        if ($varlang->value !== $value && strlen(trim($varlang->value)) > 0) {
                            echo "DIFF [{$varlang->lang_id}] [{$varlang->id}] [[{$varlang->value}]] [[{$value}]]<br>\n";
                        }

                        if ($varlang->value !== $value && strlen(trim($varlang->value)) == 0) {
                            echo "CLEAR [{$varlang->lang_id}] [{$varlang->id}] [[{$varlang->value}]] [[{$value}]]<br>\n";
                        }

                        $varlang->save();
                    } else {
                        echo "interzis [{$varlang->lang_id}] {$id} {$varlang} <br>\n";
                    }
                } else {
                    echo "clear<br>\n";
                }
            }
        }

        return [];
    }

}
