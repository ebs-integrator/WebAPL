<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    CalendarModel,
    CalendarLangModel,
    Input,
    Auth,
    Redirect,
    Language,
    jQgrid;

class Calendar extends \Core\APL\ExtensionController {

    protected $module_name = 'calendar';
    protected $layout;
    protected $page_view_mod = 'page_calendar';

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('CalendarModel', 'CalendarLangModel'));

        Actions::get('calendar/list', array('before' => 'auth', array($this, 'calendar_list')));
        Actions::post('calendar/getlist', array('before' => 'auth', array($this, 'getlist')));
        Actions::get('calendar/edit/{id}', array('before' => 'auth', array($this, 'edit_item')));
        Actions::post('calendar/create', array('before' => 'auth', array($this, 'create_item')));
        
        Actions::post('calendar/save', array('before' => 'auth', array($this, 'save')));
        Actions::post('calendar/save_lang', array('before' => 'auth', array($this, 'save_lang')));


        Actions::register('construct_left_menu', array($this, 'left_menu_item'));

        Template::registerViewMethod('page', $this->page_view_mod, 'Pagina calendar', null, true);

        $this->layout = Template::mainLayout();
    }

    public function left_menu_item() {
        echo Template::moduleView($this->module_name, 'views.calendar-left-menu');
    }

    public function calendar_list() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function edit_item($id = 0) {
        $data = array(
            'calendar' => CalendarModel::find($id)
        );

        if ($data['calendar']) {
            $langs = CalendarLangModel::where('calendar_item_id', $id)->get();
            $data['langs'] = array();
            foreach ($langs as $lang) {
                $data['langs'][$lang->lang_id] = $lang;
            }
            
            $data['posts'] = Post::join(PostLang::$ftable, PostLang::$ftable.".post_id", '=', Post::$ftable.".id")
                    ->select(CalendarPostModel::$ftable.".post_id", CalendarPostModel::$ftable.".calendar_item_id", PostLang::$ftable.".title")
                    ->join(CalendarPostModel::$ftable, CalendarPostModel::$ftable.".post_id", '=', Post::$ftable.".id")
                    ->where(CalendarPostModel::$ftable.".calendar_item_id", $id)
                    ->get();
            
            $data['posts_all'] = Post::prepareAll()
                    ->select(PostLang::$ftable.".title", Post::$ftable.".id")
                    ->where(Post::$ftable.".view_mod", $this->page_view_mod)
                    ->get();

            $this->layout->content = Template::moduleView($this->module_name, 'views.edit_form', $data);
            return $this->layout;
        } else {
            \App::abort(404);
        }
    }

    public function getlist() {
        $jqgrid = new jQgrid('apl_calendar_item');
        echo $jqgrid->populate(function ($start, $limit) {
            return CalendarModel::select(CalendarModel::$ftable . '.id', CalendarModel::$ftable . '.event_date', CalendarLangModel::$ftable . '.title', CalendarModel::$ftable . '.period', CalendarModel::$ftable . '.enabled')
                            ->leftJoin(CalendarLangModel::$ftable, CalendarLangModel::$ftable . '.calendar_item_id', '=', CalendarModel::$ftable . '.id')
                            ->where(CalendarLangModel::$ftable . '.lang_id', \Core\APL\Language::getId())
                            ->skip($start)
                            ->take($limit)
                            ->get();
        });
    }

    public function create_item() {
        $item = new CalendarModel;
        $item->period = Input::get("general.period");
        $item->event_date = Input::get("general.date");
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
        $id = Input::get('id');

        $item = CalendarModel::find($id);
        if ($item) {
            $item->period = Input::get("period");
            $item->event_date = Input::get("event_date");
            $item->enabled = Input::get("enabled") ? 1 : 0;
            $item->save();
        } else {
            throw new Exception("Calendar item #{$id} not found");
        }
    }

    public function save_lang() {
        $langs = Input::get('lang');
        
        foreach ($langs as $id => $lang) {
            $item = CalendarLangModel::find($id);
            if ($item) {
                $item->title = $lang['title'];
                $item->save();
            }
        }
    }

}
