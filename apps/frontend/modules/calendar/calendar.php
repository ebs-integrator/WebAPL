<?php

/**
 * 
 * CMS WebAPL 1.0. Platform is a free open source software for creating an managing
 * their full with CMS integrated CMS system
 * 
 * Copyright (C) 2014 Enterprise Business Solutions SRL
 * 
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with
 * this program.  If not, see <http://www.gnu.org/licenses/>.
 * You can read the copy of GNU General Public License in english here 
 * 
 * For more details about CMS WebAPL 1.0 please contact Enterprise Business
 * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
 * email to office@ebs.md 
 * 
 */
namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    CalendarModel,
    CalendarLangModel,
    Input,
    Redirect,
    PageView,
    Language;

class Calendar extends \WebAPL\ExtensionController {

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
            'current_day' => intval(date("d")),
            'events' => array()
        );

        $events = \CalendarModel::join(CalendarLangModel::getTableName(), \CalendarModel::getField('id'), '=', CalendarLangModel::getField('calendar_item_id'))
                ->join(\CalendarGroup::getTableName(), \CalendarGroup::getField('id'), '=', \CalendarModel::getField('calendar_group_id'))
                ->join(\CalendarPostModel::getTableName(), \CalendarPostModel::getField('calendar_group_id'), '=', \CalendarGroup::getField('id'))
                ->where(CalendarLangModel::getField('lang_id'), \WebAPL\Language::getId())
                ->where(\CalendarPostModel::getField('post_id'), $data['page']->id)
                ->where(\CalendarModel::getField('enabled'), 1)
                ->select(CalendarLangModel::getField("*"), \CalendarModel::getField('event_date'), \CalendarModel::getField('repeat_frequency'), \CalendarModel::getField('repeat_to_date'), \CalendarModel::getField('person_id'), \CalendarModel::getField('post_id'), \CalendarModel::getField('period'))
                ->orderBy(\CalendarModel::getField('event_date'), 'asc')
                ->get();

        $min_time = mktime(0, 0, 0, $wdata['begin_month'], 1, $wdata['begin_year']);
        $max_time = mktime(0, 0, 0, $wdata['end_month'], 1, $wdata['end_year']);


        $event_list = [];

        function add_event(&$event_list, $time, $event) {
            $year = intval(date("Y", $time));
            $month = intval(date("m", $time));
            $day = intval(date("d", $time));

            if (isset($event_list[$year][$month][$day])) {
                $event_list[$year][$month][$day][] = $event;
            } else {
                $event_list[$year][$month][$day] = [$event];
            }
        }

        foreach ($events as $event) {
            $time = strtotime($event->event_date);
            if ($min_time > $time) {
                $min_time = $time;
            }
            if ($max_time < $time) {
                $max_time = $time;
            }

            add_event($event_list, $time, $event);
            $to_time = strtotime($event->repeat_to_date);

            if ($time < $to_time && $event->repeat_frequency !== 'none') {
                switch ($event->repeat_frequency) {
                    case 'zilnic':
                        $add_time = 86400;
                        while ($time + $add_time <= $to_time) {
                            $time += $add_time;
                            add_event($event_list, $time, $event);
                        }
                        break;
                    case 'saptaminal':
                        $add_time = 86400 * 7;
                        while ($time + $add_time <= $to_time) {
                            $time += $add_time;
                            add_event($event_list, $time, $event);
                        }
                        break;
                    case 'lunar':
                        $day = date("d", $time);
                        while ($time <= $to_time) {
                            $calc_time = strtotime(date("Y-m-{$day} H:i:s", strtotime("+1 months", $time)));
                            if ($calc_time) {
                                $time = $calc_time;
                                if ($time > $to_time) {
                                    break;
                                }
                                add_event($event_list, $time, $event);
                            } else {
                                $time = strtotime("+1 months", $time);
                            }
                        }
                        break;
                    case 'anual':
                        $day = date("d", $time);
                        $month = date("m", $time);
                        while ($time <= $to_time) {
                            $calc_time = strtotime(date("Y-{$month}-{$day} H:i:s", strtotime("+1 years", $time)));
                            if ($calc_time) {
                                $time = $calc_time;
                                if ($time > $to_time) {
                                    break;
                                }
                                add_event($event_list, $time, $event);
                            } else {
                                $time = strtotime("+1 years", $time);
                            }
                        }
                        break;
                }
            }
        }

        $wdata['events'] = $event_list;

        $wdata['begin_year'] = intval(date('Y', $min_time));
        $wdata['begin_month'] = intval(date('m', $min_time));

        $wdata['end_year'] = intval(date('Y', $max_time));
        $wdata['end_month'] = intval(date('m', $max_time));

        $data['page']->text .= Template::moduleView($this->module_name, "views.calendarPage", $wdata);

        return PageView::defaultView($data);
    }

}
