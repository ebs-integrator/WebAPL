<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    ActeLocaleModel,
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

        Actions::register('construct_left_menu', array($this, 'left_menu_item'));

        //Template::registerViewMethod('page', $this->page_view_mod, 'Pagina calendar', null, true);

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

}
