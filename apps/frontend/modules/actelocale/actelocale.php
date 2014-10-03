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

        Template::registerViewMethod('page', 'acteList', 'Lista de actelocale', array($this, 'acteList'), true);
    }

    public function acteList($data) {
        $year = intval(Input::get('year'));
        $month = intval(Input::get('month'));
        
        $wdata['page_url'] = $data['page_url'];

        $data['current_year'] = $year ? $year : intval(date("m"));
        
        $data['years_list'] = \ActeLocaleModel::getYears();
        
        $wdata['current_year'] = $data['current_year'];
        $wdata['current_month'] = $month && $month >= 1 && $month <= 12 ? $month : intval(date("m"));
        $wdata['list'] = \ActeLocaleModel::extract($data['current_year']);
        
        $data['page']->text .= Template::moduleView($this->module_name, 'views.actelist', $wdata);

        return PageView::articleView($data);
    }

}
