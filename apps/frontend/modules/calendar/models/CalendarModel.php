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
class CalendarModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_calendar_item';
    public static $ftable = 'apl_calendar_item';
    public $timestamps = false;

    public static function generateEvents($events, $sorted = true) {
        $event_list = [];

        function add_event(&$event_list, $time, $event) {
            global $sorted;
            
            $event = clone $event;
            
            $event['event_date'] = date('Y-m-d H:i:s', $time);

            if ($sorted === TRUE) {
                $year = intval(date("Y", $time));
                $month = intval(date("m", $time));
                $day = intval(date("d", $time));

                if (isset($event_list[$year][$month][$day])) {
                    $event_list[$year][$month][$day][] = $event;
                } else {
                    $event_list[$year][$month][$day] = [$event];
                }
            } else {
                $event_list[] = $event;
            }
        }

        foreach ($events as $event) {
            $time = strtotime($event->event_date);

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


        return $event_list;
    }

}
