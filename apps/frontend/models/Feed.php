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

}
