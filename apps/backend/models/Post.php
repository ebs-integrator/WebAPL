<?php

class Post extends Eloquent {

    protected $table = 'apl_post';
    public $timestamps = false;

    public function langs() {
        return $this->hasMany('PostLang', 'post_id', 'id');
    }

    public static function tree($parent = 0) {
        $list = Post::where('parent', $parent)->get();

        foreach ($list as &$item) {
            $item['lang'] = $item->langs()->where('lang_id', Language::getId())->first();
            $item['list'] = Post::tree($item->id);
        }

        return $list;
    }

}
