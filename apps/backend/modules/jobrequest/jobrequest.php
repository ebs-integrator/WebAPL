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
                            ->orderBy(\JobRequestModel::getField('date_created'), 'desc')
                            ->get();
        });
    }

    public function edititem() {
        \User::onlyHas('jobrequest-view');

        $jqgrid = new jQgrid(\JobRequestModel::getTableName());
        $jqgrid->operation(array());
    }

}
