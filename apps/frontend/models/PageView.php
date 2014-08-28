<?php

class PageView {

    // INIT
    public static function run($data) {
        if (isset($data['page']['view_mod']) && Core\APL\Template::checkViewMethod('page', $data['page']['view_mod'])) {
            return Core\APL\Template::callViewMethod('page', $data['page']['view_mod'], array($data));
        } else {
            return static::defaultView($data);
        }
    }

    /** 
     *   PAGE VIEWS
     */
    public static function posturiVacante($post) {
        
    }

    public static function promisesMod($post) {
        if ($post->feed_id) {
            $data['posts'] = Post::prepareQuery()
                    ->join(FeedPost::$ftable, FeedPost::$ftable . '.post_id', Post::$ftable . ".id")
                    ->where(FeedPost::$ftable . '.feed_id', $post->feed_id)
                    ->get();
        }
    }

    public static function locationsList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata["feedPosts"] = Post::postsFeed($data['page']->feed_id);
            $data["page"]->text = View::make("sections.pages.modview.locations")->with($wdata);
        }
        return static::defaultView($data);
    }

    public static function defaultView($data) {
        return View::make('sections.pages.default')->with($data);
    }
    
    /**
     *    END PAGE VIEWS
     */

}
