<?php

class Post extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_post';
    public static $ftable = 'apl_post'; // public table name
    public $timestamps = true;
    public static $taxonomy = 1;

    public function langs() {
        return $this->hasMany('PostLang', 'post_id', 'id');
    }

    public static function tree($taxonomy_id, $parent = 0) {
        $list = Post::where('parent', $parent)->where('taxonomy_id', $taxonomy_id)->get();

        foreach ($list as &$item) {
            $item['lang'] = $item->langs()->where('lang_id', Language::getId())->first();
            $item['list'] = Post::tree($taxonomy_id, $item->id);
        }

        return $list;
    }

    public static function findTax($id, $taxonomy_id) {
        return Post::where('id', $id)->where('taxonomy_id', $taxonomy_id)->first();
    }

    public static function feedsID($post_id) {
        $ids = array();
        foreach (FeedPost::where('post_id', $post_id)->get() as $record) {
            $ids[] = $record->feed_id;
        }
        return $ids;
    }

    protected static function columns() {
        return array(Post::$ftable . ".*", PostLang::$ftable . ".id as post_lang_id", PostLang::$ftable . ".text", PostLang::$ftable . ".title", PostLang::$ftable . ".enabled", PostLang::$ftable . ".lang_id", PostLang::$ftable . ".uri");
    }

    protected static function prepareQuery() {
        return Post::join(PostLang::$ftable, PostLang::$ftable . ".post_id", '=', Post::$ftable . ".id")
                        ->select(
                                Post::columns()
                        )
                        ->where(PostLang::$ftable . ".lang_id", Language::getId())->where('taxonomy_id', self::$taxonomy);
    }

    public static function registerInCache($row) {
        if ($row) {
            self::$cache_posts[$row->id] = $row;
        }
    }

    public static function findGeneral() {
        $list = Post::prepareQuery()
                ->where(Post::getField('general_node'), 1)
                ->get();

        foreach ($list as &$item) {
            Post::registerInCache($item);
            $item['url'] = Post::getFullURI($item->id);
        }

        return $list;
    }

    public static function subPosts($parent, $max_level = 0, $clevel = 1) {
        if ($max_level == 0 || $clevel <= $max_level) {
            $list = Post::findWithParent($parent);
        } else {
            $list = array();
        }

        foreach ($list as &$item) {
            $item['childrens'] = Post::subPosts($item->id, $max_level, $clevel + 1);
        }

        return $list;
    }

    public static function findRow($where = array(), $enabled = 0) {
        $row = Post::prepareQuery();

        if ($enabled) {
            $row = $row->where(PostLang::$ftable . ".enabled", 1);
        }

        return $row->where($where)->get()->first();
    }

    public static function findWithParent($parent_id) {
        $query = Post::prepareQuery();
        $list = $query->where(array(
                    'parent' => $parent_id
                ))->get();

        foreach ($list as &$item) {
            $item['url'] = Post::getFullURI($item['id']);
        }

        return $list;
    }

    public static $cache_posts = array();

    public static function findID($id, $enabled = 0) {
        if (isset(self::$cache_posts[$id]) && self::$cache_posts[$id]) {
            $item = self::$cache_posts[$id];
        } else {
            $item = Post::findRow(
                            array(Post::$ftable . ".id" => $id), $enabled
            );
            self::$cache_posts[$id] = $item;
        }

        return $item;
    }

    public static function findURI($uri, $enabled = 0) {
        return Post::findRow(
                        array(PostLang::$ftable . ".uri" => $uri), $enabled
        );
    }

    public static function getParents($parent_id) {
        $list = array();
        while ($parent_id) {
            $item = Post::findID($parent_id);
            if ($item) {
                $list[] = $item->toArray();
                $parent_id = $item->parent;
            } else {
                $parent_id = 0;
            }
        }
        return $list;
    }

    public static function getFullURI($id, $full = true) {
        $parents = Post::getParents($id);
        $uri_segments = array();
        foreach (array_reverse($parents) as $parent) {
            $uri_segments[] = $parent['uri'];
        }

        $furi = implode('/', $uri_segments);

        if ($full) {
            return Post::getURL($furi);
        } else {
            return $furi;
        }
    }

    public static function getURL($uri) {
        return Core\APL\Language::url("page/" . $uri);
    }

    public static function oneView($id) {
        $post = Post::find($id);
        if ($post) {
            $post->views = $post->views + 1;
            $post->save();
        }
    }

    public static function setFeedPagination($posts_instance, $feed_id) {
        $feed = Feed::getFeed($feed_id);

        if ($feed->limit_type == 'pagination') {
            return $posts_instance->paginate($feed->limit_value);
        } else {
            return $posts_instance->get();
        }
    }

    public static function withDinamicFields($post) {
        $values_SQL = "(SELECT * FROM " . FeedFieldValue::getTableName() . " WHERE " . FeedFieldValue::getField("lang_id") . " IN (0," . Core\APL\Language::getId() . ") AND " . FeedFieldValue::getField("post_id") . " = {$post->id}) as sb";

        $fields = FeedField::leftJoin(DB::raw($values_SQL), "sb.feed_field_id", "=", FeedField::getField("id"))
                ->select(FeedField::getField("fkey"), "sb.value", FeedField::getField("get_filter"))
                ->join(FeedRel::getTableName(), FeedRel::getField('feed_field_id'), '=', FeedField::getField('id'))
                ->join(FeedPost::getTableName(), FeedPost::getField('feed_id'), '=', FeedRel::getField('feed_id'))
                ->where(FeedPost::getField('post_id'), '=', $post->id)
                ->get();
        foreach ($fields as $field) {
            if ($field->get_filter && method_exists('DinamicFields', $field->get_filter)) {
                $post[$field->fkey] = call_user_func(array('DinamicFields', $field->get_filter), $field, $post);
            } else {
                $post[$field->fkey] = $field->value;
            }
        }

        return $post;
    }

    public static function postsFeed($feed_id, $with_cover = false, $get_instance = false) {
        $feed = Feed::getFeed($feed_id);
        $posts = array();

        if ($feed) {
            Post::$taxonomy = 2;
            $posts = Post::prepareQuery()
                    ->join(FeedPost::getTableName(), Post::getField("id"), '=', FeedPost::getField("post_id"))
                    ->where(FeedPost::getField("feed_id"), $feed_id)
                    ->select(
                    Post::columns() + array(FeedPost::getField("feed_id"))
            );


            if ($feed->order_type != 'none' && $feed->order_by != 'none') {
                $posts = $posts->orderBy($feed->order_by, $feed->order_type);
            }

            if ($feed->limit_type == 'strictlimit') {
                $posts = $posts->take($feed->limit_value);
            }

            if ($get_instance) {
                return $posts;
            } else {
                if ($feed->limit_type == 'pagination') {
                    $posts = $posts->paginate($feed->limit_value);
                } else {
                    $posts = $posts->get();
                }
            }

            foreach ($posts as &$post) {
                $post = Post::withDinamicFields($post);

                if ($with_cover) {
                    $post['cover'] = Post::coverImage($post->id);
                }
            }
        }

        return $posts;
    }

    public static function coverImage($id) {
        return Files::where(array(
                    'module_name' => 'post_cover',
                    'module_id' => $id
                ))->get()->first();
    }

}
