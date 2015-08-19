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
class HomeController extends BaseController
{

    function __construct()
    {
        parent::__construct();

        $this->beforeFilter(function () {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';

    public function postLangs()
    {
        User::onlyHas('lang-view');

        $jqgrid = new jQgrid('apl_lang');
        echo $jqgrid->populate(function ($start, $limit) {
            return DB::table('apl_lang')->get();
        });
        $this->layout = null;
    }

    public function postEditlang()
    {
        User::onlyHas('lang-view');

        $oper = Input::get('oper');
        $id = Input::get('id');

        if ($id == 1) {
            Log::error("Editing lang #{$id} disabled");
            return [];
        }

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

    public function showDashboard()
    {
        $page = Post::find(285);
        if ($page) {
            $data['page'] = PostLang::where('post_id', $page->id)->where('lang_id', WebAPL\Language::getId())->first();
        }

        $this->layout->content = View::make('hello', $data);
    }

    public function getLanguages()
    {
        User::onlyHas('lang-view');

        $this->layout->content = View::make('sections.language.list');
    }

    public function showPage()
    {
        echo 'test backend';
    }

    public function getChangelang($ext)
    {
        WebAPL\Language::setLanguage($ext);

        return Redirect::back();
    }

    public function getEmpty()
    {
        return ['no no no'];
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

    public function postPostsavepart()
    {
        $switch = Input::get('switch');
        $kappa = Files::where('id', $switch)->first();
        if ($kappa->status==0) {
            $kappa->status = 1;
        } else {
            $kappa->status = 0;
        }
        $kappa->save();
        return [];
    }
    public function postPostsaveord(){
        $order = Input::get('order');
        $id = Input::get('id');

        $kappa = Files::where('id', $id)->first();
        $kappa->ord = $order;

        $kappa->save();
        return[];
    }
}
