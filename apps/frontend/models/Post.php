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
        $list = Post::where('parent', $parent)->where(Post::getField('is_trash'), 0)->where('taxonomy_id', $taxonomy_id)->orderBy('ord_num', 'asc')->get();

        foreach ($list as &$item) {
            $item['lang'] = $item->langs()->where('lang_id', Language::getId())->first();
            $item['list'] = Post::tree($taxonomy_id, $item->id);
        }

        return $list;
    }

    public static function treePosts($parent = 0, $begin_where = array()) {
        $list = Post::prepareQuery()->where(Post::getField('parent'), $parent)->where($begin_where)->orderBy('ord_num', 'asc')->get();

        foreach ($list as &$item) {
            $item['list'] = Post::treePosts($item->id);
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

    public static function prepareQuery($taxonomy_id = 0) {
        $query = Post::join(PostLang::$ftable, PostLang::$ftable . ".post_id", '=', Post::$ftable . ".id")
                ->select(
                        Post::columns()
                )
                ->where(PostLang::$ftable . ".lang_id", Language::getId())
                ->where(Post::getField('is_trash'), 0);

        if ($taxonomy_id) {
            $query = $query->where(Post::getField('taxonomy_id'), $taxonomy_id);
        } elseif (self::$taxonomy) {
            $query = $query->where(Post::getField('taxonomy_id'), self::$taxonomy);
        }

        return $query;
    }

    public static function registerInCache($row) {
        if ($row) {
            self::$cache_posts[$row->id] = $row;
        }
    }

    public static function findGeneral() {
        $list = Post::prepareQuery()
                ->where(Post::getField('general_node'), 1)
                ->orderBy('ord_num', 'asc')
                ->get();

        foreach ($list as &$item) {
            Post::registerInCache($item);
            $item['url'] = Post::getFullURI($item->id);
            $item['image_icon'] = Files::getfile('page_icon', $item->id);
            $item['image_icon_active'] = Files::getfile('page_icon_active', $item->id);
            $item['image_icon_big'] = Files::getfile('page_icon_big', $item->id);
        }

        return $list;
    }

    public static function findHomePosts($modView) {
        $current_tax = static::$taxonomy;
        static::$taxonomy = 2;
        $post = Post::prepareQuery(1)->where('view_mod', $modView)->take(2)->first();

        if ($post) {
            $list = Post::prepareQuery()
                    ->join(FeedPost::getTableName(), FeedPost::getField('post_id'), '=', Post::getField('id'))
                    ->where(Post::getField('to_home'), 1)
                    ->where(FeedPost::getField('feed_id'), $post->feed_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        } else {
            $list = array();
        }
        static::$taxonomy = $current_tax;
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
                ))->orderBy('ord_num', 'asc')->get();

        foreach ($list as &$item) {
            $item['url'] = Post::getFullURI($item['id']);
            $item['properties'] = PostProperty::getPostProperties($item['id']);
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
                    ->where(PostLang::getField('enabled'), 1)
                    ->where(Post::getField('is_trash'), 0)
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

    public static function applyDate($post_instance, $year = '', $month = '', $day = '') {
        if ($year) {
            $post_instance = $post_instance->where(DB::raw("YEAR(" . Post::getField('created_at') . ")"), $year);
        }
        if ($month) {
            $post_instance = $post_instance->where(DB::raw("MONTH(" . Post::getField('created_at') . ")"), $month);
        }
        if ($day) {
            $post_instance = $post_instance->where(DB::raw("DAY(" . Post::getField('created_at') . ")"), $day);
        }

        return $post_instance;
    }

    public static function search($string, $paginate = true) {
        $words = explode(' ', trim(strip_tags($string)));

        if ($words) {
            self::$taxonomy = 0;
            $query = Post::prepareQuery()->where(PostLang::getField('enabled'), 1);
            $query = $query->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $word = trim($word);
                    if ($word) {
                        $query = $query->orWhere(PostLang::getField('title'), 'like', "%{$word}%");
                        $query = $query->orWhere(PostLang::getField('text'), 'like', "%{$word}%");
                    }
                }
            });

            if ($paginate) {
                return $query->paginate(10);
            } else {
                return $query->get();
            }
        } else {
            return [];
        }
    }

    public static function rssPosts() {
        static::$taxonomy = 2;
        return Post::prepareQuery()->where(PostLang::getField('enabled'), 1)->orderBy(Post::getField('created_at'), 'desc')->take(50)->get();
    }

}
