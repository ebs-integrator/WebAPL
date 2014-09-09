<?php

class PostLang extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_post_lang';
    public static $ftable = 'apl_post_lang'; // public table name
    public $timestamps = false;

    public static function uniqURI($id, $title = '') {
        $uri = Core\APL\Actions::toAscii($title);

        $clear_count = PostLang::whereRaw("uri like ? AND id <> ?", array($uri, $id))->count();

        if ($clear_count == 0) {
            return $uri;
        }

        $count = PostLang::whereRaw("uri like '{$uri}%' AND id <> ?", array($id))->count();
        if ($count) {
            return $uri . '-' . $count;
        } else {
            return $uri;
        }
    }

}
