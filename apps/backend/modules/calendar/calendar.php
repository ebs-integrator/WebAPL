<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    CalendarModel,
    CalendarLangModel,
    jQgrid;

class Calendar extends \Core\APL\ExtensionController {

    protected $module_name = 'calendar';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('CalendarModel', 'CalendarLangModel'));

        Actions::get('calendar/list', array('before' => 'auth', array($this, 'calendar_list')));
        Actions::post('calendar/getlist', array('before' => 'auth', array($this, 'getlist')));
        Actions::post('calendar/edit/{id}', array('before' => 'auth', array($this, 'edit_item')));

        Actions::register('construct_left_menu', array($this, 'left_menu_item'));
        
        Template::registerViewMethod('page', 'page_calendar', 'Pagina calendar', null, true);

        $this->layout = Template::mainLayout();
    }

    public function left_menu_item() {
        echo Template::moduleView($this->module_name, 'views.calendar-left-menu');
    }

    public function calendar_list() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function edit_item() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.edit_form');

        return $this->layout;
    }

    public function getlist() {
        $jqgrid = new jQgrid('apl_calendar_item');
        echo $jqgrid->populate(function ($start, $limit) {
            return CalendarModel::select(CalendarModel::$ftable . '.id', CalendarModel::$ftable . '.event_date', CalendarLangModel::$ftable . '.title', CalendarLangModel::$ftable . '.period')
                            ->leftJoin(CalendarLangModel::$ftable, CalendarLangModel::$ftable . '.calendar_item_id', '=', CalendarModel::$ftable . '.id')
                            ->where(CalendarLangModel::$ftable . '.lang_id', \Core\APL\Language::getId())
                            ->skip($start)
                            ->take($limit)
                            ->get();
        });
    }

}
