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
 * */

namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    CalendarModel,
    CalendarLangModel,
    Input,
    Redirect,
    PageView,
    Route,
    DB,
    Language;

class Calendar extends \WebAPL\ExtensionController {

    protected $module_name = 'calendar';
    protected $layout;
    protected $page_view_mod = 'page_calendar';

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('CalendarModel', 'CalendarLangModel'));

        Route::get('calendar/cron', [$this, 'email_notifications']);

        $cron_date = \SettingsModel::one('calendar_cron_time');
        if (date("Y-m-d", intval($cron_date)) !== date('Y-m-d')) {
            \SettingsModel::put('calendar_cron_time', time());
            $this->email_notifications();
        }

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

        $event_list = \CalendarModel::generateEvents($events);

        foreach ($event_list as $event_year) {
            foreach ($event_year as $event_month) {
                foreach ($event_month as $event_day) {
                    foreach ($event_day as $event) {

                        $time = strtotime($event->event_date);

                        if ($min_time > $time) {
                            $min_time = $time;
                        }
                        if ($max_time < $time) {
                            $max_time = $time;
                        }
                        
                    }
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

    public function email_notifications() {
        if (\WebAPL\Modules::checkInstance('person')) {

            $events = \CalendarModel::join(CalendarLangModel::getTableName(), \CalendarModel::getField('id'), '=', CalendarLangModel::getField('calendar_item_id'))
                    ->join(\CalendarGroup::getTableName(), \CalendarGroup::getField('id'), '=', \CalendarModel::getField('calendar_group_id'))
                    ->join(\CalendarPostModel::getTableName(), \CalendarPostModel::getField('calendar_group_id'), '=', \CalendarGroup::getField('id'))
                    ->where(CalendarLangModel::getField('lang_id'), \WebAPL\Language::getId())
                    ->where(\CalendarModel::getField('enabled'), 1)
                    ->where(\CalendarModel::getField('person_id'), '<>', 0)
                    ->select(CalendarLangModel::getField("*"), \CalendarModel::getField('event_date'), \CalendarModel::getField('repeat_frequency'), \CalendarModel::getField('repeat_to_date'), \CalendarModel::getField('person_id'), \CalendarModel::getField('post_id'), \CalendarModel::getField('period'))
                    ->orderBy(\CalendarModel::getField('event_date'), 'asc')
                    ->where(function ($query) {
                        $query->where(function ($query) {
                            $query->where(DB::raw("DATE(" . CalendarModel::getField('event_date') . ")"), '=', DB::raw('DATE(CURRENT_TIMESTAMP)'));
                        })->orWhere(function ($query) {
                            $query->where(\CalendarModel::getField('event_date'), '<=', DB::raw('CURRENT_TIMESTAMP'))
                            ->where(\CalendarModel::getField('repeat_to_date'), '>=', DB::raw('CURRENT_TIMESTAMP'))
                            ->where(\CalendarModel::getField('repeat_frequency'), '<>', 'none');
                        });
                    })
                    ->get();

            $event_list = \CalendarModel::generateEvents($events, false);

            $today_events = [];
            foreach ($event_list as $event) {
                if (date("Y-m-d", strtotime($event['event_date'])) === date("Y-m-d") && (strtotime($event['event_date']) >= time())) {
                    echo " sendone ";
                    $today_events[] = $event;
                    $this->loadClass(['PersonModel'], 'person');
                    $person = \PersonModel::getPerson($event['person_id']);
                    if (isset($person->email) && $person->email) {
                        Template::viewModule($this->module_name, function () use ($person, $event) {
                            \EmailModel::sendToAddress($person->email, "Do you have an event today", 'views.calendarEmail', ['person' => $person, 'event' => $event]);
                        });
                    }
                }
            }
        }
    }

}
