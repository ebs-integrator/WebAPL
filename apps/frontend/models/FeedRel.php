<?php

class FeedRel extends Eloquent {

    
    use EloquentTrait;
    
    protected $table = 'apl_feed_rel';
    public static $ftable = 'apl_feed_rel'; // public table name
    public $timestamps = false;
    
}