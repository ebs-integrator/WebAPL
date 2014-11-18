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
    ActeLocaleModel,
    Input,
    Route,
    Event,
    jQgrid;

class Actelocale extends \WebAPL\ExtensionController {

    protected $module_name = 'actelocale';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('ActeLocaleModel'));

        Route::get('actelocale/list', array('before' => 'auth', array($this, 'acte_list')));
        Route::post('actelocale/getlist', array('before' => 'auth', array($this, 'getlist')));

        Route::get('actelocale/create', array('before' => 'auth', array($this, 'create')));
        Route::get('actelocale/edit/{id}', array('before' => 'auth', array($this, 'editact')));

        Route::get('actelocale/parse', array('before' => 'auth', array($this, 'parse')));


        Route::post('actelocale/save', array('before' => 'auth', array($this, 'save')));



        Event::listen('construct_left_menu', array($this, 'left_menu_item'));

        Template::registerViewMethod('page', 'acteList', 'Lista de acte locale', null, true);

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
