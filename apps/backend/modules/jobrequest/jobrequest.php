<?php

namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    Input,
    JobRequestModel,
    PostLang,
    Route,
    Event,
    jQgrid;

class Jobrequest extends \WebAPL\ExtensionController {

    protected $module_name = 'jobrequest';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('JobRequestModel'));

        Route::get('jobrequest/list', array('before' => 'auth', array($this, 'requests_list')));
        Route::post('jobrequest/getlist', array('before' => 'auth', array($this, 'getlist')));
        Route::post('jobrequest/edititem', array('before' => 'auth', array($this, 'edititem')));

        Event::listen('construct_left_menu', array($this, 'left_menu_item'));

        $this->layout = Template::mainLayout();
    }

    public function left_menu_item() {
        if (\User::has('jobrequest-view')) {
            echo Template::moduleView($this->module_name, 'views.jobrequest-left-menu');
        }
    }

    public function requests_list() {
        \User::onlyHas('jobrequest-view');

        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function getlist() {
        \User::onlyHas('jobrequest-view');

        $jqgrid = new jQgrid(\JobRequestModel::getTableName());
        echo $jqgrid->populate(function ($start, $limit) {
            return \JobRequestModel::join(PostLang::getTableName(), \PostLang::getField('post_id'), '=', \JobRequestModel::getField('post_id'))
                            ->where(\PostLang::getField('lang_id'), \WebAPL\Language::getId())
                            ->select(\JobRequestModel::getField('id'), \PostLang::getField('title'), \JobRequestModel::getField('name'), \JobRequestModel::getField('cv_path'), \JobRequestModel::getField('date_created'))
                            ->skip($start)
                            ->take($limit)
                            ->get();
        });
    }

    public function edititem() {
        \User::onlyHas('jobrequest-view');

        $jqgrid = new jQgrid(\JobRequestModel::getTableName());
        $jqgrid->operation(array());
    }

}
