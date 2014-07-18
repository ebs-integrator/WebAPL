<?php

class PageController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';

    public function getIndex($page_id = 0) {
        if ($page_id) {
            $this->data['page'] = Post::find($page_id);
            if ($this->data['page']) {
                $this->data['page_langs'] = $this->data['page']->langs();
            }
        }

        $this->data['tree_pages'] = Post::tree();

        View::share($this->data);
        $this->layout->content = View::make('sections.page.layout');
    }

    public function postCreate() {
        $parent = Input::get('parent');

        $page = new Post;
        $page->parent = $parent;
        $page->author_id = Auth::user()->id;
        $page->save();

        foreach (Language::getList() as $lang) {
            $pageLang = new PostLang;
            $pageLang->lang_id = $lang->id;
            $pageLang->post_id = $page->id;
            $pageLang->save();
        }

        return Redirect::to('page/index/' . $page->id);
    }

    public function postSave() {
        $page_id = Input::get('id');
        $page = Input::get('page');

        $post = Post::find($page_id);
        $post->date_create = $page['date_create'];
        $post->date_update = DB::raw('CURRENT_TIMESTAMP');
        $post->parent = $page['parent'];
        $post->save();
        
        return Redirect::to('page/index/'.$page_id);
    }

}
