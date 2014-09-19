<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    CalendarModel,
    CalendarLangModel,
    Input,
    Redirect,
    PageView,
    Language;

class Calendar extends \Core\APL\ExtensionController {

    protected $module_name = 'calendar';
    protected $layout;
    protected $page_view_mod = 'page_calendar';

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('CalendarModel', 'CalendarLangModel'));

        Template::registerViewMethod('page', $this->page_view_mod, 'Pagina calendar', array($this, 'calendarViewMod'), true);
    }

    public function calendarViewMod($data) {
        $wdata = array(
            ''
        );
        
        $data['page']->text .= Template::moduleView($this->module_name, "views.calendarPage", $wdata);
        
        return PageView::defaultView($data);
    }

}
