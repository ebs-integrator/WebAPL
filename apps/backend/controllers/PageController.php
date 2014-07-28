<?php

class PageController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
                    if (!Auth::check()) {
                        return Redirect::to('auth');
                    }
                });
        
        $this->taxonomy = Taxonomy::get('page');
    }

    protected $taxonomy;
    protected $layout = 'layout.main';

    public function getIndex($page_id = 0) {
        if ($page_id) {
            $this->data['page'] = Post::findTax($page_id, $this->taxonomy->id);
            if ($this->data['page']) {
                $this->data['page_langs'] = $this->data['page']->langs()->get();
            }
        }

        $this->data['tree_pages'] = Post::tree($this->taxonomy->id);

        View::share($this->data);
        $this->layout->content = View::make('sections.page.layout');
    }

    public function postCreate() {
        $parent = Input::get('parent');

        $page = new Post;
        $page->parent = $parent;
        $page->author_id = Auth::user()->id;
        $page->taxonomy_id = $this->taxonomy->id;
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
        $page_lang = Input::get('lang');

        $post = Post::find($page_id);
        if ($post && $page) {
            $post->created_at = $page['created_at'];
            $post->updated_at = DB::raw('CURRENT_TIMESTAMP');
            if ($post->parent != $post->id) {
                $post->parent = $page['parent'];
            }
            $post->save();
        }
        
        if ($page_lang) {
            foreach ($page_lang as $page_lang_id => $page_lang) {
                $post_lang = PostLang::find($page_lang_id);
                $post_lang->title = $page_lang['title'];
                $post_lang->text = $page_lang['text'];
                $post_lang->enabled = isset($page_lang['enabled']) && $page_lang ? 1 : 0;
                if ($page_lang['uri']) {
                    $post_lang->uri = $page_lang['uri'];
                } else {
                    $post_lang->uri = $page_lang['title'];
                }
                $post_lang->save();
            }
        }

        return array(
        );
    }

}
