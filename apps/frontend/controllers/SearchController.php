<?php

class SearchController extends BaseController {

    protected $layout = 'layout/page';

    public function results() {
        $keywords = Input::get('words');

        $this->data['words'] = strip_tags($keywords);
        $this->data['results'] = Post::search($keywords);

        $this->layout->content = View::make('sections.search.results', $this->data);
    }

    public function topost($id) {

        $post = Post::find($id);

        if ($post) {
            switch ($post->taxonomy_id) {
                case 1:
                    $uri = Post::getFullURI($post->id, true);
                    return Redirect::to($uri);
                    break;
                case 2:
                    $feed = FeedPost::where('post_id', $post->id)->first();
                    if ($feed) {
                        $post = Post::where('feed_id', $feed->feed_id)->first();
                        if ($post) {
                            $uri = Post::getFullURI($post->id, true);
                            return Redirect::to($uri);
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

}
