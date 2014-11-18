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
  **/
 
namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Shortcodes,
    jQgrid,
    SComplaintsModel,
    Input,
    Route,
    Event,
    WebAPL\Template;

class Socialcomplaints extends \WebAPL\ExtensionController {

    protected $module_name = 'socialcomplaints';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array(
            'SComplaintsModel'
        ));

        // Set settings page
        Shortcodes::register('scomplaint', array());

        Route::get('socialcomplaints/list', array('before' => 'auth', array($this, 'soclist')));
        Route::post('socialcomplaints/getlist', array('before' => 'auth', array($this, 'getlist')));
        Route::post('socialcomplaints/edititem', array('before' => 'auth', array($this, 'edititem')));

        Template::registerViewMethod('page', 'secial_complaints_list', 'Lista cu plângeri', null, true);

        Event::listen('construct_left_menu', array($this, 'left_menu_item'));

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
                ->where(\PostLang::getField('lang_id'), \WebAPL\Language::getId())
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
            return \SComplaintsModel::select('id', 'post_id', 'username', 'email', 'address', 'title', 'text', 'response', 'date_created', 'is_private', 'enabled')->skip($start)->take($limit)->orderBy('date_created', 'desc')->get();
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
