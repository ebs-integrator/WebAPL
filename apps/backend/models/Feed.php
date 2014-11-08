<?php

class Feed extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_feed';
    public $timestamps = false;
    
    public function rposts() {
        return $this->hasMany('FeedPost', 'feed_id', 'id');
    }
    
    public static function getPostFeeds($post_id) {
        return Feed::join(FeedPost::getTableName(), FeedPost::getField('feed_id'), '=', Feed::getField('id'))
                ->where(FeedPost::getField('post_id'), '=', $post_id)
                ->select(Feed::getField('*'))
                ->get();
    }
    
}