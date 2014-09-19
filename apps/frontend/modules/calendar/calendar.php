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
            'begin_year' => 2014,
            'begin_month' => 1,
            'end_year' => intval(date("Y")) + 2,
            'end_month' => 11,
            'current_year' => intval(date("Y")),
            'current_month' => intval(date("m")),
            'events' => array()
        );

        $events = \CalendarModel::join(CalendarLangModel::getTableName(), \CalendarModel::getField('id'), '=', CalendarLangModel::getField('calendar_item_id'))
                ->join(\CalendarGroup::getTableName(), \CalendarGroup::getField('id'), '=', \CalendarModel::getField('calendar_group_id'))
                ->join(\CalendarPostModel::getTableName(), \CalendarPostModel::getField('calendar_group_id'), '=', \CalendarGroup::getField('id'))
                ->where(CalendarLangModel::getField('lang_id'), \Core\APL\Language::getId())
                ->where(\CalendarPostModel::getField('post_id'), $data['page']->id)
                ->where(\CalendarModel::getField('enabled'), 1)
                ->select(CalendarLangModel::getField("*"), \CalendarModel::getField('event_date'), \CalendarModel::getField('period'))
                ->orderBy(\CalendarModel::getField('event_date'), 'asc')
                ->get();
        
        foreach ($events as $event) {
            $time = strtotime($event->event_date);
            $year = intval(date("Y", $time));
            $month = intval(date("m", $time));
            $day = intval(date("d", $time));
            if (!isset($wdata['events'][$year][$month][$day])) {
                $wdata['events'][$year][$month][$day] = array();
            }
            $wdata['events'][$year][$month][$day][] = $event;
        }

        $data['page']->text .= Template::moduleView($this->module_name, "views.calendarPage", $wdata);

        return PageView::defaultView($data);
    }

}
