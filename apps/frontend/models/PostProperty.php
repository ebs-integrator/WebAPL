<?php

class PostProperty extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_post_property';
    public $timestamps = false;

    public static function prepare() {
        return Post::prepareQuery(1)
                        ->join(PostPropertyRel::getTableName(), Post::getField('id'), '=', PostPropertyRel::getField('post_id'))
                        ->join(PostProperty::getTableName(), PostProperty::getField('id'), '=', PostPropertyRel::getField('post_property_id'))
                        ->orderBy(Post::getField('ord_num'), 'asc');
    }

    public static function postsWithProperty($property, $take = 0) {
        $instance = PostProperty::prepare()
                ->where(PostProperty::getField('key'), $property);

        if ($take) {
            $instance = $instance->take($take);
        }

        return $instance->get();
    }

    public static function postWithProperty($property, $with_url = false) {
        $row = PostProperty::prepare()
                        ->where(PostProperty::getField('key'), $property)
                        ->first();
                
        if ($row && $with_url) {
            $row['url'] = Post::getFullURI($row->id);
        } 
        
        return $row;
    }

    public static $properties = array();
    public static function getPostProperties($id) {
        if (isset(static::$properties[$id])) {
            return static::$properties[$id];
        }
        
        $list = PostPropertyRel::join(PostProperty::getTableName(), PostProperty::getField('id'), '=', PostPropertyRel::getField('post_property_id'))
                ->where(PostPropertyRel::getField('post_id'), $id)
                ->get();

        $names = array();

        foreach ($list as $item) {
            $names[] = $item->key;
        }

        static::$properties[$id] = $names;
        return $names;
    }

}
