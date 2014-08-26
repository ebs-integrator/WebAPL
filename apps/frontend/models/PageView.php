<?php

class PageView {
    
    public static function posturiVacante($post) {
        
    }
    
    public static function promisesMod($post) {        
        if ($post->feed_id) {
            $data['posts'] = Post::prepareQuery()
                    ->join(FeedPost::$ftable, FeedPost::$ftable.'.post_id', Post::$ftable.".id")
                    ->where(FeedPost::$ftable.'.feed_id', $post->feed_id)
                    ->get();
            
            
        }        
    }
    
}