<?php

class SearchController extends BaseController {

    protected $layout = 'layout/page';

    public function results() {
        $keywords = Input::get('words');

        $this->data['words'] = strip_tags($keywords);
        $this->data['results'] = Post::search($keywords);

        Core\APL\Template::setPageTitle("Search: {$this->data['words']}", true);

        PageController::loadGeneralResources();

        $this->layout->content = View::make('sections.search.results', $this->data);
    }

    public function topost($id) {

        $post = Post::find($id);

        if ($post) {
            switch ($post->taxonomy_id) {
                case 1:
                    $uri = Post::getFullURI($post->id, true);
                    return Redirect::to($uri);
                case 2:
                    $feed = FeedPost::where('post_id', $post->id)->first();
                    if ($feed) {
                        $page = Post::where('feed_id', $feed->feed_id)->first();
                        if ($page) {
                            $viewmods = Core\APL\Template::getViewMethodList('page');
                            $uri = Post::getFullURI($page->id, true);

                            if (isset($viewmods[$page->view_mod]['support_item']) && $viewmods[$page->view_mod]['support_item']) {
                                $plang = PostLang::where('post_id', $post->id)->where('lang_id', \Core\APL\Language::getId())->first();
                                if ($plang) {
                                    $url = $uri . "?item=" . $plang->uri;
                                } else {
                                    $url = $uri;
                                }
                            } else {
                                $url = $uri;
                            }

                            return Redirect::to($url);
                        }
                    }
                    break;
                default:
                    throw new Exception("Not found taxonomy, post #{$id}");
                    break;
            }
        } else {
            throw new Exception("Post not found #{$id}");
        }
    }

    public function topage($modview) {
        $post = Post::where('view_mod', $modview)->first();

        if ($post) {
            $uri = Post::getFullURI($post->id, true);
            return Redirect::to($uri);
        } else {
            throw new Exception("Post not found #{$modview}");
        }
    }

}
