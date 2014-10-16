<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    ActeLocaleModel,
    Input,
    jQgrid;

class Actelocale extends \Core\APL\ExtensionController {

    protected $module_name = 'actelocale';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('ActeLocaleModel'));

        Actions::get('actelocale/list', array('before' => 'auth', array($this, 'acte_list')));
        Actions::post('actelocale/getlist', array('before' => 'auth', array($this, 'getlist')));

        Actions::get('actelocale/create', array('before' => 'auth', array($this, 'create')));
        Actions::get('actelocale/edit/{id}', array('before' => 'auth', array($this, 'editact')));

        Actions::get('actelocale/parse', array('before' => 'auth', array($this, 'parse')));


        Actions::post('actelocale/save', array('before' => 'auth', array($this, 'save')));



        Actions::register('construct_left_menu', array($this, 'left_menu_item'));

        Template::registerViewMethod('page', 'acteList', 'Lista de actelocale', null, true);

        $this->layout = Template::mainLayout();
    }

    public function left_menu_item() {
        if (\User::has('actelocale-view')) {
            echo Template::moduleView($this->module_name, 'views.acte-left-menu');
        }
    }

    public function acte_list() {
        \User::onlyHas('actelocale-view');

        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function getlist() {
        \User::onlyHas('actelocale-view');

        $jqgrid = new jQgrid(ActeLocaleModel::getTableName());
        echo $jqgrid->populate(function ($start, $limit) {
            return ActeLocaleModel::orderBy(ActeLocaleModel::getField('date_upload'), 'desc')
                            ->skip($start)
                            ->take($limit)
                            ->get();
        });
    }

    public function create() {
        $id = ActeLocaleModel::createEmpty();

        return \Redirect::to('actelocale/edit/' . $id);
    }

    public function editact($id) {
        \User::onlyHas('actelocale-view');

        $data['act'] = ActeLocaleModel::find($id);

        if ($data['act']) {
            $this->layout->content = Template::moduleView($this->module_name, 'views.form', $data);

            return $this->layout;
        } else {
            throw new Exception("Record not found");
        }
    }

    public function save() {
        $id = Input::get('id');

        $item = \ActeLocaleModel::find($id);
        if ($item) {
            $item->doc_nr = Input::get('doc_nr');
            $item->title = Input::get('title');
            $item->date_upload = Input::get('date_upload');
            $item->type = Input::get('type');
            $item->emitent = Input::get('emitent');
            $item->save();
        }
    }

    public function parse() {
        //

        $datain = '01.10.2008';
        $dataout = '08.10.2014';
        $lang = 'ro';
        $primarii = '182+152+158+153+154+155+156+157';



        $data = file_get_contents("http://www.actelocale.md/actspublish.php?datain={$datain}&dataout={$dataout}&selPrimarie={$primarii}&selDomen=0&u=0&decizii=1&dispozitii=1&tablestyle=1&l={$lang}");

        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        @$dom->loadHTML($data);

        $domList = $dom->getElementsByTagName("tr");

        foreach ($domList as $tr) {
            $subnodes = $tr->getElementsByTagName('td');
            if ($subnodes->length === 6) {
                
            }
        }

        return [];
    }

}
