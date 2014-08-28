<?php

class FeedField extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_feed_field';
    public $timestamps = false;

    public static function get($feed_id, $post_id, $lang_id = 0) {
        
        
        $stmt = FeedField::join('apl_feed_rel', 'apl_feed_field.id', '=', 'apl_feed_rel.feed_field_id')
                ->leftJoin('apl_feed_field_value', function($join) use ($post_id, $lang_id) {
                            $join->on('apl_feed_field_value.feed_field_id', '=', 'apl_feed_field.id');
                            $join->where('apl_feed_field_value.post_id', '=', (int)$post_id);
                            if ($lang_id) {
                                $join->where('apl_feed_field_value.lang_id', '=', (int)$lang_id);
                            }
                        })
                ->select('apl_feed_field.*', 'apl_feed_field_value.value');

        if (is_array($feed_id)) {
            $stmt = $stmt->whereIn('apl_feed_rel.feed_id', $feed_id);
        } else {
            $stmt = $stmt->where('apl_feed_rel.feed_id', $feed_id);
        }
        
        if ($lang_id) {
            $stmt = $stmt->where('apl_feed_field.lang_dependent', 1);
        } else {
            $stmt = $stmt->where('apl_feed_field.lang_dependent', 0);
        }

        return $stmt->distinct()->get();
    }

}