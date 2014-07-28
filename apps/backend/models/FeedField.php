<?php

class FeedField extends Eloquent {

    protected $table = 'apl_feed_field';
    public $timestamps = false;
    
    public static function get($feed_id) {
        
        $stmt = FeedField::where('apl_feed_field.lang_dependent', 0)
                ->join('apl_feed_rel', 'apl_feed_field.id', '=', 'apl_feed_rel.feed_field_id')
                ->leftJoin('apl_feed_field_value', 'apl_feed_field_value.feed_field_id', '=', 'apl_feed_field.id')
                ->select('apl_feed_field.*', 'apl_feed_field_value.value');
        
        if (is_array($feed_id)) {
            $stmt = $stmt->whereIn('apl_feed_rel.feed_id', $feed_id);
        } else {
            $stmt = $stmt->where('apl_feed_rel.feed_id', $feed_id);
        }
        
        return $stmt->get();
    }
    
}