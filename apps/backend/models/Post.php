<?php 
 
 /**
  * 
  * CMS Platform WebAPL 1.0 is a free open source software for creating and managing
  * a web site for Local Public Administration institutions. The platform was
  * developed at the initiative and on a concept of USAID Local Government Support
  * Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
  * The opinions expressed on the website belong to their authors and do not
  * necessarily reflect the views of the United States Agency for International
  * Development (USAID) or the US Government.
  * 
  * This program is free software: you can redistribute it and/or modify it under
  * the terms of the GNU General Public License as published by the Free Software
  * Foundation, either version 3 of the License, or any later version.
  * This program is distributed in the hope that it will be useful, but WITHOUT ANY
  * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  * PARTICULAR PURPOSE. See the GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License along with
  * this program. If not, you can read the copy of GNU General Public License in
  * English here: <http://www.gnu.org/licenses/>.
  * 
  * For more details about CMS WebAPL 1.0 please contact Enterprise Business
  * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
  * email to office@ebs.md 
  * 
  **/
 
class Post extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_post';
    public static $ftable = 'apl_post'; // public table name
    public $timestamps = true;

    public function langs() {
        return $this->hasMany('PostLang', 'post_id', 'id');
    }

    public static function tree($taxonomy_id, $parent = 0) {
        $list = Post::where('parent', $parent)->where('taxonomy_id', $taxonomy_id)->orderBy('ord_num', 'asc')->remember(60)->get();

        foreach ($list as &$item) {
            $item['lang'] = $item->langs()->where('lang_id', Language::getId())->remember(60)->first();
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
