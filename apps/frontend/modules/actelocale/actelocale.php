<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    PageView,
    Input,
    ActeLocaleModel;

class Actelocale extends \Core\APL\ExtensionController {

    protected $module_name = 'actelocale';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('ActeLocaleModel'));

        Actions::register('home_right_top', array($this, 'loadHome'));

        Template::registerViewMethod('page', 'acteList', 'Lista de actelocale', array($this, 'acteList'), true);
    }

    public function acteList($data) {
        $year = intval(Input::get('year'));
        $month = intval(Input::get('month'));

        $wdata['page_url'] = $data['page_url'];

        $data['current_year'] = $year ? $year : intval(date("Y"));

        $data['years_list'] = \ActeLocaleModel::getYears();

        $wdata['current_year'] = $data['current_year'];
        $wdata['current_month'] = $month && $month >= 1 && $month <= 12 ? $month : intval(date("m"));
        $wdata['list'] = \ActeLocaleModel::extract($data['current_year']);

        $data['page']->text .= Template::moduleView($this->module_name, 'views.actelist', $wdata);

        return PageView::articleView($data);
    }

    public function loadHome($page) {
        $page_properies = \PostProperty::getPostProperties($page->id);
        if (in_array('show_file_page', $page_properies)) {
            $data = array();
            $data['acte'] = ActeLocaleModel::prepare()->orderBy('date_upload', 'desc')->take(2)->get();
            echo Template::moduleView($this->module_name, 'views.sidebar-acte', $data)->render();
        }
    }

}
