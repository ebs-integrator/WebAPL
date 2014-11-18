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
    CalendarModel,
    CalendarLangModel,
    CalendarGroup,
    Input,
    Auth,
    Redirect,
    Language,
    Post,
    PostLang,
    Route,
    Event,
    CalendarPostModel,
    jQgrid;

class Calendar extends \WebAPL\ExtensionController {

    protected $module_name = 'calendar';
    protected $layout;
    protected $page_view_mod = 'page_calendar';

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('CalendarModel', 'CalendarLangModel', 'CalendarGroup'));

        Route::get('calendar/list', array('before' => 'auth', array($this, 'calendar_list')));
        Route::post('calendar/getlist', array('before' => 'auth', array($this, 'getlist')));
        Route::get('calendar/edit/{id}', array('before' => 'auth', array($this, 'edit_item')));
        Route::post('calendar/create', array('before' => 'auth', array($this, 'create_item')));

        Route::post('calendar/getgroups', array('before' => 'auth', array($this, 'getgroups')));
        Route::post('calendar/editgroup', array('before' => 'auth', array($this, 'editgroup')));

        Route::post('calendar/save', array('before' => 'auth', array($this, 'save')));
        Route::post('calendar/save_lang', array('before' => 'auth', array($this, 'save_lang')));

        Event::listen('page_attachment', array($this, 'page_group_attachment'));
        Route::post('calendar/save_post_attach', array('before' => 'auth', array($this, 'save_post_attach')));

        Event::listen('construct_left_menu', array($this, 'left_menu_item'));
        Event::listen('language_created', array($this, 'language_created'));
        Event::listen('language_deleted', array($this, 'language_deleted'));

        Template::registerViewMethod('page', $this->page_view_mod, 'Calendar', null, true);

        $this->layout = Template::mainLayout();

        Event::listen('feed_post_bottom', [$this, 'post_event']);
        Route::post('calendar/save_post_cal_attach', array('before' => 'auth', array($this, 'save_post_cal_attach')));


        Route::post('calendar/get_person_list/{id}', array('before' => 'auth', array($this, 'get_person_list')));
    }

    public function get_person_list($id) {
        \User::onlyHas('calendar-view');

        $jqgrid = new jQgrid(\CalendarModel::getTableName());

        echo $jqgrid->populate(function ($start, $limit) use ($id) {
            return CalendarModel::select(CalendarModel::getField('id'), CalendarLangModel::getField('title'))
                            ->join(CalendarLangModel::getTableName(), CalendarLangModel::getField('calendar_item_id'), '=', CalendarModel::getField('id'))
                            ->where(CalendarLangModel::getField('lang_id'), '=', Language::getId())
                            ->where(CalendarModel::getField('person_id'), '=', $id)
                            ->skip($start)
                            ->take($limit)
                            ->get();
        });
    }

    public function post_event($post) {
        if (\User::has('calendar-view')) {
            $count = \CalendarModel::where('post_id', $post['id'])->count();

            echo Template::moduleView($this->module_name, 'views.post-attachment', ['post' => $post, 'activated' => ($count > 0 ? true : false)]);
        }
    }

    public function save_post_cal_attach() {

        $id = Input::get('post_id');

        $count = \CalendarModel::where('post_id', $id)->count();

        if ($count == 0) {
            $post = Post::find($id);
            $calendar = new \CalendarModel;
            $calendar->post_id = $id;
            $calendar->event_date = $post->created_at;

            $field = \FeedFieldValue::join(\FeedField::getTableName(), \FeedField::getField('id'), '=', \FeedFieldValue::getField('feed_field_id'))->where([
                        'post_id' => $id,
                        \FeedField::getField('fkey') => 'hours'
                    ])->first();

            if ($field) {
                $calendar->period = $field->value;
            }

            $calendar->save();

            $postLangs = \PostLang::where('post_id', $id)->get();
            foreach ($postLangs as $postLang) {
                $calendarLang = new CalendarLangModel;
                $calendarLang->calendar_item_id = $calendar->id;
                $calendarLang->title = $postLang->title;
                $calendarLang->lang_id = $postLang->lang_id;
                $calendarLang->save();
            }
        } else {
            $calendar = CalendarModel::where('post_id', $id)->get();
            foreach ($calendar as $item) {
                CalendarLangModel::where('calendar_item_id', $item->id)->delete();
            }
            CalendarModel::where('post_id', $id)->delete();
        }
    }

    public function left_menu_item() {
        if (\User::has('calendar-view')) {
            echo Template::moduleView($this->module_name, 'views.calendar-left-menu');
        }
    }

    public function calendar_list() {
        \User::onlyHas('calendar-view');

        $data['groups'] = \CalendarGroup::orderBy('name', 'asc')->get();

        $this->layout->content = Template::moduleView($this->module_name, 'views.list', $data);

        return $this->layout;
    }

    public function edit_item($id = 0) {
        \User::onlyHas('calendar-view');

        $data = array(
            'calendar' => CalendarModel::find($id)
        );

        if ($data['calendar']) {
            $langs = CalendarLangModel::where('calendar_item_id', $id)->get();
            $data['langs'] = array();
            foreach ($langs as $lang) {
                $data['langs'][$lang->lang_id] = $lang;
            }

            if (\WebAPL\Modules::checkInstance('person')) {
                $this->loadClass(['PersonLangModel'], 'person');
                $data['persons'] = \PersonLangModel::where('lang_id', Language::getId())
                        ->orderBy(\DB::raw(\PersonLangModel::getField('first_name') . ', ' . \PersonLangModel::getField('last_name')), 'asc')
                        ->get();
            }

            $data['groups'] = \CalendarGroup::orderBy('name', 'asc')->get();

//            $data['posts'] = Post::join(PostLang::$ftable, PostLang::$ftable . ".post_id", '=', Post::$ftable . ".id")
//                    ->select(CalendarPostModel::$ftable . ".post_id", CalendarPostModel::$ftable . ".calendar_item_id", PostLang::$ftable . ".title")
//                    ->join(CalendarPostModel::$ftable, CalendarPostModel::$ftable . ".post_id", '=', Post::$ftable . ".id")
//                    ->where(CalendarPostModel::$ftable . ".calendar_item_id", $id)
//                    ->get();
//
//            $data['posts_all'] = Post::prepareAll()
//                    ->select(PostLang::$ftable . ".title", Post::$ftable . ".id")
//                    ->where(Post::$ftable . ".view_mod", $this->page_view_mod)
//                    ->get();

            $this->layout->content = Template::moduleView($this->module_name, 'views.edit_form', $data);
            return $this->layout;
        } else {
            \App::abort(404);
        }
    }

    public function getlist() {
        \User::onlyHas('calendar-view');

        $jqgrid = new jQgrid('apl_calendar_item');
        echo $jqgrid->populate(function ($start, $limit) {
            return CalendarModel::select(CalendarModel::$ftable . '.id', CalendarModel::$ftable . '.event_date', CalendarLangModel::$ftable . '.title', CalendarModel::$ftable . '.period', CalendarModel::$ftable . '.enabled')
                            ->leftJoin(CalendarLangModel::$ftable, CalendarLangModel::$ftable . '.calendar_item_id', '=', CalendarModel::$ftable . '.id')
                            ->where(CalendarLangModel::$ftable . '.lang_id', \WebAPL\Language::getId())
                            ->skip($start)
                            ->take($limit)
                            ->get();
        });
    }

    public function getgroups() {
        \User::onlyHas('calendar-view');

        $jqgrid = new jQgrid(\CalendarGroup::getTableName());
        echo $jqgrid->populate(function ($start, $limit) {
            return CalendarGroup::select(\CalendarGroup::getField('id'), \CalendarGroup::getField('name'))
                            ->skip($start)->take($limit)->get();
        });
    }

    public function editgroup() {
        \User::onlyHas('calendar-view');

        $jqgrid = new jQgrid(\CalendarGroup::getTableName());
        $jqgrid->operation(array(
            'name' => Input::get('name')
        ));
    }

    public function create_item() {
        \User::onlyHas('calendar-view');

        $item = new CalendarModel;
        $item->period = Input::get("general.period");
        $item->event_date = Input::get("general.date");
        $item->calendar_group_id = Input::get("general.calendar_group_id");
        $item->user_id = Auth::user()->id;
        $item->save();

        foreach (Input::get("lang") as $lang_id => $lang) {
            $itemLang = new CalendarLangModel;
            $itemLang->lang_id = $lang_id;
            $itemLang->calendar_item_id = $item->id;
            $itemLang->title = $lang['name'];
            $itemLang->save();
        }

        return Redirect::to("calendar/edit/{$item->id}");
    }

    public function save() {
        \User::onlyHas('calendar-view');

        $id = Input::get('id');

        $item = CalendarModel::find($id);
        if ($item) {
            $item->period = Input::get("period");
            $item->event_date = Input::get("event_date");
            $item->calendar_group_id = Input::get("group_id");
            $item->enabled = Input::get("enabled") ? 1 : 0;

            $item->repeat_frequency = Input::get("repeat_frequency");
            $item->repeat_to_date = Input::get("repeat_to_date");

            $item->person_id = Input::get("person_id") ? Input::get("person_id") : 0;

            $item->save();
        } else {
            throw new Exception("Calendar item #{$id} not found");
        }
    }

    public function save_lang() {
        \User::onlyHas('calendar-view');

        $langs = Input::get('lang');

        foreach ($langs as $id => $lang) {
            $item = CalendarLangModel::find($id);
            if ($item) {
                $item->title = $lang['title'];
                $item->location = $lang['location'];
                $item->save();
            }
        }
    }

    public function page_group_attachment($post) {
        if ($post->view_mod == $this->page_view_mod && \User::has('calendar-view')) {
            $wdata = array(
                'post' => $post->toArray(),
                'calendar_groups' => \CalendarGroup::orderBy('name', 'asc')->get(),
                'selected_groups' => array()
            );

            $selected_groups = \CalendarPostModel::where('post_id', $post->id)->get();
            foreach ($selected_groups as $item) {
                $wdata['selected_groups'][] = $item->calendar_group_id;
            }

            echo Template::moduleView($this->module_name, 'views.attachment-calendar-page', $wdata);
        }
    }

    public function save_post_attach() {
        \User::onlyHas('calendar-view');

        $page_id = Input::get('page_id');
        $groups = Input::get('calendar_groups');
        CalendarPostModel::where('post_id', $page_id)->delete();
        if ($groups) {
            foreach ($groups as $group) {
                $item = new CalendarPostModel;
                $item->post_id = $page_id;
                $item->calendar_group_id = $group;
                $item->save();
            }
        }

        return array();
    }

    public function language_created($lang_id) {
        $list = CalendarModel::all();
        foreach ($list as $ent) {
            $item = new CalendarLangModel;
            $item->calendar_item_id = $ent->id;
            $item->lang_id = $lang_id;
            $item->save();
        }
    }

    public function language_deleted($lang_id) {
        CalendarLangModel::where('lang_id', $lang_id)->delete();
    }

}
