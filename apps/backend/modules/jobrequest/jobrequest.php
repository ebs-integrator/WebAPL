<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    Input,
    JobRequestModel,
    PostLang,
    jQgrid;

class Jobrequest extends \Core\APL\ExtensionController {

    protected $module_name = 'jobrequest';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('JobRequestModel'));

        Actions::get('jobrequest/list', array('before' => 'auth', array($this, 'requests_list')));
        Actions::post('jobrequest/getlist', array('before' => 'auth', array($this, 'getlist')));
        Actions::post('jobrequest/edititem', array('before' => 'auth', array($this, 'edititem')));

        Actions::register('construct_left_menu', array($this, 'left_menu_item'));

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
                            ->where(\PostLang::getField('lang_id'), \Core\APL\Language::getId())
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
