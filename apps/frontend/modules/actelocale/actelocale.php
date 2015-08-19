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
    PageView,
    Input,
    Event,
    Files,
    ActeLocaleModel;

class Actelocale extends \WebAPL\ExtensionController
{

    protected $module_name = 'actelocale';
    protected $layout;

    public function __construct()
    {
        parent::__construct();

        $this->loadClass(array('ActeLocaleModel'));

        Event::listen('home_right_top', array($this, 'loadHome'));

        Template::registerViewMethod('page', 'acteList', 'Lista de actelocale', array($this, 'acteList'), true);
    }

    public function acteList($data)
    {
        $year = intval(Input::get('year'));
        $month = intval(Input::get('month'));

        $wdata['page_url'] = $data['page_url'];

        $data['current_year'] = $year ? $year : intval(date("Y"));

        $data['years_list'] = \ActeLocaleModel::getYears();

        $wdata['current_year'] = $data['current_year'];
        $wdata['current_month'] = $month && $month >= 1 && $month <= 12 ? $month : intval(date("m"));

        $wdata['last'] = \ActeLocaleModel::last($data['current_year']);

        if ($wdata['last']) {
            $wdata['current_month'] = (int)date('m', strtotime($wdata['last']['date_upload']));
        }
        $wdata['list'] = \ActeLocaleModel::extract($data['current_year']);

        $data['page']->text .= Template::moduleView($this->module_name, 'views.actelist', $wdata);

        return PageView::articleView($data);
    }

    public function loadHome($page)
    {
        $page_properies = \PostProperty::getPostProperties($page->id);
        if (in_array('show_file_page', $page_properies)) {
            $data = array();
            $data['acte'] = ActeLocaleModel::join(Files::getTableName(), Files::getField('module_id'), '=', ActeLocaleModel::getField('id'))
                ->where(Files::getField('module_name'), 'actelocale')
                ->select(ActeLocaleModel::getField("*"), Files::getField('path'))
                ->orderBy('date_upload', 'desc')->take(2)->get();
            echo Template::moduleView($this->module_name, 'views.sidebar-acte', $data)->render();
        }
    }

}
