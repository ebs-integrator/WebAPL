<?php

class Feed extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_feed';
    public $timestamps = false;
    
    public function rposts() {
        return $this->hasMany('FeedPost', 'feed_id', 'id');
    }
    
}