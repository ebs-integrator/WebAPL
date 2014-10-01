<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Shortcodes,
    jQgrid,
    SComplaintsModel,
        Input,
    Core\APL\Template;

class Socialcomplaints extends \Core\APL\ExtensionController {

    protected $module_name = 'socialcomplaints';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array(
            'SComplaintsModel'
        ));

        // Set settings page
        Shortcodes::register('scomplaint', array());

        Actions::get('socialcomplaints/list', array('before' => 'auth', array($this, 'soclist')));
        Actions::post('socialcomplaints/getlist', array('before' => 'auth', array($this, 'getlist')));
        Actions::post('socialcomplaints/edititem', array('before' => 'auth', array($this, 'edititem')));

        Template::registerViewMethod('page', 'secial_complaints_list', 'Lista cu plingeri', null, true);

        Actions::register('construct_left_menu', array($this, 'left_menu_item'));

        // Set layout
        $this->layout = Template::mainLayout();
    }

    public function left_menu_item() {
        if (\User::has('socialc-view')) {
            echo Template::moduleView($this->module_name, 'views.scomplaint-left-menu');
        }
    }

    public function soclist() {
        \User::onlyHas('socialc-view');

        $pages = \Post::join(\PostLang::getTableName(), \PostLang::getField('post_id'), '=', \Post::getField('id'))
                ->where(\PostLang::getField('lang_id'), \Core\APL\Language::getId())
                ->where(\Post::getField('taxonomy_id'), 1)
                ->orderBy(\PostLang::getField('title'), 'desc')
                ->get();

        $page_list = array();
        $page_json = array();
        foreach ($pages as $page) {
            $page_list[] = "{$page->post_id}:{$page->title}";
            $page_json[$page->post_id] = $page->title;
        }
        $data['pagesString'] = implode(';', $page_list);
        $data['pagesJson'] = json_encode($page_json);

        $this->layout->content = Template::moduleView($this->module_name, 'views.list', $data);

        return $this->layout;
    }

    public function getlist() {
        \User::onlyHas('socialc-view');

        $jqgrid = new jQgrid('apl_complaint');
        echo $jqgrid->populate(function ($start, $limit) {
            return \SComplaintsModel::select('id', 'post_id', 'username', 'email', 'address', 'title', 'text', 'response', 'date_created', 'is_private', 'enabled')->skip($start)->take($limit)->get();
        });
    }

    public function edititem() {
        \User::onlyHas('socialc-view');

        $jqgrid = new jQgrid('apl_complaint');
        $jqgrid->operation(array(
            'post_id' => Input::get('post_id'),
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'address' => Input::get('address'),
            'title' => Input::get('title'),
            'text' => Input::get('text'),
            'response' => Input::get('response'),
            'date_created' => Input::get('date_created'),
            'is_private' => Input::get('is_private') ? 1 : 0,
            'enabled' => Input::get('enabled') ? 1 : 0
        ));
    }

}
