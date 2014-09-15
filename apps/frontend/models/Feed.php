<?php

class Feed extends Eloquent {

    protected $table = 'apl_feed';
    public $timestamps = false;
    protected static $cache_feed = array();

    public function rposts() {
        return $this->hasMany('FeedPost', 'feed_id', 'id');
    }

    public static function getFeed($feed_id) {
        if (isset(static::$cache_feed[$feed_id])) {
            $feed = static::$cache_feed[$feed_id];
        } else {
            $feed = Feed::where('id', $feed_id)
                    ->where('enabled', 1)
                    ->get()
                    ->first();
            static::$cache_feed[$feed_id] = $feed;
        }

        return $feed;
    }

    public static function getYears($feed_id) {
        return Post::join(FeedPost::getTableName(), FeedPost::getField('post_id'), '=', Post::getField('id'))
                ->distinct()
                ->orderBy(Post::getField('created_at'), 'desc')
                ->select(DB::raw("YEAR(" . Post::getField('created_at') . ") as year"))
                ->where(FeedPost::getField('feed_id'), '=', $feed_id)
                ->get();
    }
    
    public static function getMonths($feed_id, $year) {
        
    }

}
