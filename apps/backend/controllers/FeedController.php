<?php

class FeedController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
                    if (!Auth::check()) {
                        return Redirect::to('auth');
                    }
                });

        $this->taxonomy = Taxonomy::get('article');
    }

    protected $layout = 'layout.main';
    protected $taxonomy;

    public function getIndex() {
        $this->data['list'] = Feed::all();

        $this->layout->content = View::make('sections.feed.list', $this->data);
    }

    /**
     * Create new feed page
     */
    public function getCreate() {
        $this->data['fields'] = FeedField::all();

        $this->layout->content = View::make('sections.feed.create', $this->data);
    }

    /**
     * create new feed
     * @return redir
     */
    public function postTakecreate() {

        $general = Input::get('general');

        $feed = new Feed;
        $feed->name = $general['name'];
        $feed->enabled = isset($general['enabled']) ? 1 : 0;
        $feed->limit_type = $general['limit_type'];
        $feed->limit_value = $general['limit_value'];
        $feed->order_type = $general['order_type'];
        $feed->order_by = $general['order_by'];
        $feed->save();

        $fields = Input::get('fields');
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $frel = new FeedRel;
                $frel->feed_id = $feed->id;
                $frel->feed_field_id = $field;
                $frel->save();
            }
        }

        return Redirect::to('feed/edit/' . $feed->id);
    }

    /**
     * feed edit page
     * @param type $id
     */
    public function getEdit($id) {
        $this->data['feed'] = Feed::find($id);

        if ($this->data['feed']) {
            $this->layout->content = View::make('sections.feed.edit', $this->data);
        } else {
            App::abort(404);
        }
    }

    /**
     * create new empty post
     * @param int $feed_id
     * @return redir
     */
    public function getNewpost($feed_id = 0) {
        $this->data['feed_id'] = $feed_id;

        $post = new Post;
        $post->author_id = Auth::user()->id;
        $post->taxonomy_id = $this->taxonomy->id;
        $post->parent = 0;
        $post->save();

        if ($feed_id) {
            $feedpost = new FeedPost;
            $feedpost->post_id = $post->id;
            $feedpost->feed_id = $feed_id;
            $feedpost->save();
        }

        foreach (Language::getList() as $lang) {
            $postlang = new PostLang;
            $postlang->lang_id = $lang->id;
            $postlang->post_id = $post->id;
            $postlang->save();
        }

        return Redirect::to('feed/editpost/' . $post->id);
    }

    /**
     * edit post page
     * @param int $post_id
     */
    public function getEditpost($post_id) {
        $post = Post::find($post_id);

        $feedsID = Post::feedsID($post_id);

        $this->data['general'] = array(
            'post' => $post,
            'feeds' => Feed::all(),
            'post_feeds' => $feedsID,
            'fields' => $feedsID ? FeedField::get($feedsID, $post_id) : array()
        );

        $this->data['post_langs'] = array();
        foreach ($post->langs()->get() as $pl) {
            $this->data['post_langs'][$pl->lang_id] = $pl;
            $this->data['post_langs'][$pl->lang_id]['fields'] = $feedsID ? FeedField::get($feedsID, $post_id, $pl->lang_id) : array();
        }



        $this->layout->content = View::make('sections.feed.post-form')->with($this->data);
    }

    /**
     * save feed changes
     * @return array
     */
    public function postSave() {
        $id = Input::get('id');
        $general = Input::get('general');

        $feed = Feed::find($id);
        $feed->name = $general['name'];
        $feed->enabled = isset($general['enabled']) ? 1 : 0;
        $feed->limit_type = $general['limit_type'];
        $feed->limit_value = $general['limit_value'];
        $feed->order_type = $general['order_type'];
        $feed->order_by = $general['order_by'];
        $feed->save();

        return array();
    }

    /**
     * save post changes
     * @return array
     */
    public function postPostsave() {
        $id = Input::get('id');

        $response = array();

        // update Post record
        $general = Input::get('post');
        if ($general && $id) {
            $response['Post'] = 1;

            $post = Post::findTax($id, $this->taxonomy->id);
            $post->created_at = $general['created_at'];
            $post->save();
        }

        // update FeedPost records
        $feedposts = Input::get('feed_post');
        if ($feedposts && is_array($feedposts) && $id) {
            $response['FeedPost'] = 1;

            FeedPost::where('post_id', $id)->delete();
            foreach ($feedposts as $feedpost)
                if ($feedpost) {
                    $fpost = new FeedPost;
                    $fpost->post_id = $id;
                    $fpost->feed_id = $feedpost;
                    $fpost->save();
                }
        }

        // update dinamic post fields 
        $dinamic_post_fields = Input::get('dinamic_post');
        FeedFieldValue::where('post_id', $id)->where('lang_id', 0)->delete();
        foreach ($dinamic_post_fields as $field_id => $field_value) {
            $field = FeedField::find($field_id);
            $fieldValue = new FeedFieldValue;
            $fieldValue->feed_field_id = $field_id;
            $fieldValue->post_id = $id;
            if ($field->check_filter && method_exists('DinamicFields', $field->check_filter)) {
                $fieldValue->value = call_user_func(array('DinamicFields', $field->check_filter), $field_value);
            } else {
                $fieldValue->value = $field_value;
            }
            $fieldValue->save();
        }



        return $response;
    }

    public function postLangpostsave() {
        $response = array();

        $id = Input::get('id');
        $lang_id = Input::get('lang_id');

        // update PostLang records
        $postlang = Input::get('postlang');
        if ($postlang) {
            $response['PostLang'] = 1;

            foreach ($postlang as $plang_id => $plang) {
                $post_lang = PostLang::find($plang_id);
                $post_lang->title = $plang['title'];
                $post_lang->text = $plang['text'];
                $post_lang->enabled = isset($plang['enabled']) ? 1 : 0;
                $post_lang->save();
            }
        }

        // update dinamic lang fields
        $dinamic_lang_fields = Input::get('dinamic_lang');
        FeedFieldValue::where('post_id', $id)->where('lang_id', $lang_id)->delete();
        foreach ($dinamic_lang_fields as $field_id => $field_value) {
            $field = FeedField::find($field_id);
            $fieldValue = new FeedFieldValue;
            $fieldValue->feed_field_id = $field_id;
            $fieldValue->post_id = $id;
            $fieldValue->lang_id = $lang_id;
            if ($field->check_filter && method_exists('DinamicFields', $field->check_filter)) {
                $fieldValue->value = call_user_func(array('DinamicFields', $field->check_filter), $field_value);
            } else {
                $fieldValue->value = $field_value;
            }
            $fieldValue->save();
        }

        return $response;
    }

    /**
     * Get posts for jqgrid
     * @return json
     */
    public function postPosts($feed_id) {
        Session::put('feed_id', $feed_id);

        $jqgrid = new jQgrid(Post::$ftable);
        $jqgrid->use_populate_count = true;
        echo $jqgrid->populate(function ($start, $limit) {
                    $feed_id = Session::get('feed_id');
                    $list = DB::table(Post::$ftable)
                            ->join(PostLang::$ftable, Post::$ftable . ".id", '=', PostLang::$ftable . '.post_id')
                            ->join(FeedPost::$ftable, FeedPost::$ftable . ".post_id", '=', Post::$ftable . ".id")
                            ->select(Post::$ftable . '.id', PostLang::$ftable . '.title', Post::$ftable . '.created_at', Post::$ftable . '.views')
                            ->where(PostLang::$ftable . '.lang_id', Language::getId())
                            ->where(Post::$ftable . '.taxonomy_id', $this->taxonomy->id)
                            ->where(FeedPost::$ftable . ".feed_id", $feed_id)
                            ->orderBy(Post::$ftable . '.created_at', 'desc');

                    if ($limit) {
                        $list = $list->skip($start)->take($limit);
                    }

                    return $list->get($list);
                });
        $this->layout = null;
    }

    public function postPostattach() {
        $post = Post::find(Input::get('post_id'));
        $post->feed_id = Input::get('id');
        $post->save();
    }

}