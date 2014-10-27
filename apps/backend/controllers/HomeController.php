<?php

class HomeController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';

    public function postLangs() {
        User::onlyHas('lang-view');

        $jqgrid = new jQgrid('apl_lang');
        echo $jqgrid->populate(function ($start, $limit) {
            return DB::table('apl_lang')->get();
        });
        $this->layout = null;
    }

    public function postEditlang() {
        User::onlyHas('lang-view');

        $oper = Input::get('oper');
        $id = Input::get('id');

        $jqgrid = new jQgrid('apl_lang');
        $result = $jqgrid->operation(array(
            'name' => Input::get('name'),
            'ext' => Input::get('ext'),
            'enabled' => Input::get('enabled')
        ));

        $this->layout = null;

        if ($oper == 'add') {
            Event::fire('language_created', $result);

            Post::addLang($result);
            VarLangModel::addLang($result);
        }
        if ($oper == 'del') {
            Event::fire('language_deleted', $id);

            Post::removeLang($id);
            VarLangModel::removeLang($id);
        }

        Log::info("Lang operation {$oper} #{$id}");
    }

    public function showDashboard() {
//        
//        PostLang::where('title', '<>', '')->update(array(
//            'uri' => ''
//        ));
//        
//        $postlangs = PostLang::all();
//        foreach ($postlangs as $pl) {
//            $pl->uri = PostLang::uniqURI($pl->id, $pl->title);
//            $pl->save();
//        }

        $this->layout->content = View::make('hello');
    }

    public function getLanguages() {
        User::onlyHas('lang-view');

        $this->layout->content = View::make('sections.language.list');
    }

    public function showPage() {
        echo 'test backend';
    }

    public function getChangelang($ext) {
        Core\APL\Language::setLanguage($ext);

        return Redirect::back();
    }

    public function getEmpty() {

        // BAD EMPTY FUNCTION
        // delete posts
        $posts = Post::where('taxonomy_id', 2)->get();
        foreach ($posts as $post) {
            PostLang::where('post_id', $post->id)->delete();
            Files::dropMultiple('post_cover', $post->id);
            Files::dropMultiple('doc_post', $post->id);
            Files::dropMultiple('doc_post_lang', $post->id);
            $post->delete();
        }
        DB::table('apl_feed_field_value')->truncate();
        DB::table('apl_feed_post')->truncate();
        DB::table(PostLang::getTableName())->update(array(
            'text' => ''
        ));

        // delete acte
        $actes = DB::table('apl_acte')->get();
        foreach ($actes as $act) {
            Files::dropMultiple('actelocale', $act->id);
        }
        DB::table('apl_acte')->truncate();

        // calendar
        DB::table('apl_calendar_group')->truncate();
        DB::table('apl_calendar_item')->truncate();
        DB::table('apl_calendar_item_lang')->truncate();
        DB::table('apl_calendar_post')->truncate();

        // complaint
        DB::table('apl_complaint')->truncate();

        // firechat
        DB::table('apl_firechat')->truncate();

        // gallery
        $galls = DB::table('apl_gallery')->get();
        foreach ($galls as $gal) {
            Files::dropMultiple('gallery', $gal->id);
        }
        DB::table('apl_gallery')->truncate();
        DB::table('apl_gallery_post')->truncate();

        // reqs
        $reqs = DB::table('apl_job_requests')->get();
        foreach ($reqs as $req) {
            if ($req->cv_path && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $req->cv_path)) {
                @unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $req->cv_path);
            }
        }
        DB::table('apl_job_requests')->truncate();

        // logs
        DB::table('apl_logs')->truncate();

        // menu
        DB::table('apl_menu')->truncate();
        DB::table('apl_menu_item')->truncate();
        DB::table('apl_menu_item_lang')->truncate();

        // newsletter
        DB::table('apl_newsletter')->truncate();

        // persons
        $persons = DB::table('apl_person')->get();
        foreach ($persons as $person) {
            Files::dropMultiple('person', $person->id);
            Files::dropMultiple('person_chat', $person->id);
        }
        DB::table('apl_person_audience')->truncate();
        DB::table('apl_person')->truncate();
        DB::table('apl_person_lang')->truncate();
        DB::table('apl_person_rel')->truncate();


        // polls
        DB::table('apl_poll')->truncate();
        DB::table('apl_poll_answer')->truncate();
        DB::table('apl_poll_answer_lang')->truncate();
        DB::table('apl_poll_question')->truncate();
        DB::table('apl_poll_votes')->truncate();

        // pagefiles
        $pagefiles = DB::table('apl_file')->where('module_name', 'article_cover')->get();
        foreach ($pagefiles as $pf) {
            Files::drop($pf->id);
        }
        DB::table('apl_file')->where('module_name', 'page')->delete();

        // othfiles
        $files = DB::table('apl_file')->where('module_name', 'article_cover')->get();
        foreach ($files as $file) {
            Files::drop($file->id);
        }
        DB::table('apl_file')->where('module_name', 'article_cover')->delete();

        $files = DB::table('apl_file')->where('module_name', 'doc_post_lang')->get();
        foreach ($files as $file) {
            Files::drop($file->id);
        }
        DB::table('apl_file')->where('module_name', 'doc_post_lang')->delete();

        $files = DB::table('apl_file')->where('module_name', 'test')->get();
        foreach ($files as $file) {
            Files::drop($file->id);
        }
        DB::table('apl_file')->where('module_name', 'test')->delete();

        $files = DB::table('apl_file')->where('module_name', 'person')->get();
        foreach ($files as $file) {
            Files::drop($file->id);
        }
        DB::table('apl_file')->where('module_name', 'person')->delete();

        $files = DB::table('apl_file')->where('module_name', 'rewwe')->get();
        foreach ($files as $file) {
            Files::drop($file->id);
        }
        DB::table('apl_file')->where('module_name', 'rewwe')->delete();
        
        return ['executed'];
    }

}
