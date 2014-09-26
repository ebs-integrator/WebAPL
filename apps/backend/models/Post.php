<?php

class Post extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_post';
    public static $ftable = 'apl_post'; // public table name
    public $timestamps = true;

    public function langs() {
        return $this->hasMany('PostLang', 'post_id', 'id');
    }

    public static function tree($taxonomy_id, $parent = 0) {
        $list = Post::where('parent', $parent)->where('taxonomy_id', $taxonomy_id)->orderBy('ord_num', 'asc')->get();

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

    public static function prepareAll($with_feed = false) {
        $query = DB::table(Post::$ftable)
                ->join(PostLang::$ftable, Post::$ftable . ".id", '=', PostLang::$ftable . '.post_id')
                ->where(PostLang::$ftable . '.lang_id', Language::getId())
                ->orderBy(Post::$ftable . '.created_at', 'desc');
        if ($with_feed) {
            $query = $query->join(FeedPost::$ftable, FeedPost::$ftable . ".post_id", '=', Post::$ftable . ".id");
        }
        return $query;
    }
    
    public static function addLang($lang_id) {
        $pages = Post::all();
        foreach ($pages as $item) {
            $page_lang = new PostLang;
            $page_lang->lang_id = $lang_id;
            $page_lang->post_id = $item->id;
            $page_lang->save();
        }
    }
    
    public static function removeLang($lang_id) {
        PostLang::where('lang_id', $lang_id)->delete();
    }

}
