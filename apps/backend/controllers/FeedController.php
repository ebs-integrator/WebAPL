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
        User::onlyHas('feed-view');

        $this->data['list'] = Feed::all();

        $this->layout->content = View::make('sections.feed.list', $this->data);
    }

    /**
     * Create new feed page
     */
    public function getCreate() {
        User::onlyHas('feed-create');

        $this->data['fields_groups'] = FeedFieldGroup::all();
        $this->data['fields'] = FeedField::all();

        $this->layout->content = View::make('sections.feed.create', $this->data);
    }

    /**
     * create new feed
     * @return redir
     */
    public function postTakecreate() {
        User::onlyHas('feed-create');

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

        Log::info("Create new feed '{$general['name']}'");

        return Redirect::to('feed/edit/' . $feed->id);
    }

    /**
     * feed edit page
     * @param type $id
     */
    public function getEdit($id) {
        User::onlyHas('feed-edit');

        $this->data['feed'] = Feed::find($id);
        if (!$this->data['feed']) {
            throw new Exception('Feed not found #' . $id);
        }

        $this->data['fields'] = FeedField::orderBy(FeedField::getField('title'), 'asc')->get();
        $this->data['fields_selected'] = FeedField::get_($id);
        $this->data['fields_selected_arr'] = [];
        foreach ($this->data['fields_selected'] as $field) {
            $this->data['fields_selected_arr'][] = $field->id;
        }

        $this->data['post_count'] = Feed::getPostCount($id);

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
        User::onlyHas('feedpost-edit');

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

        Log::info("Create new post #{$post->id}");

        return Redirect::to('feed/editpost/' . $post->id);
    }

    /**
     * edit post page
     * @param int $post_id
     */
    public function getEditpost($post_id) {
        User::onlyHas('feedpost-edit');

        $post = Post::find($post_id);

        if (empty($post->id) === TRUE) {
            throw new Exception("Post not found!");
        }
        
        $feedsID = Post::feedsID($post_id);

        $this->data['general'] = array(
            'post' => $post,
            'feeds' => Feed::orderBy('name', 'asc')->get(),
            'post_feeds' => $feedsID,
            'fields' => $feedsID ? FeedField::get($feedsID, $post_id, 0, 1) : array(),
            'fields_out' => $feedsID ? FeedField::get($feedsID, $post_id, 0, 0) : array()
        );

        $this->data['post_langs'] = array();
        foreach ($post->langs()->get() as $pl) {
            $this->data['post_langs'][$pl->lang_id] = $pl;
            $this->data['post_langs'][$pl->lang_id]['fields'] = $feedsID ? FeedField::get($feedsID, $post_id, $pl->lang_id) : array();
            $this->data['post_langs'][$pl->lang_id]['fields_out'] = $feedsID ? FeedField::get($feedsID, $post_id, $pl->lang_id, 0) : array();
        }
        
        $this->layout->content = View::make('sections.feed.post-form')->with($this->data);
    }

    /**
     * save feed changes
     * @return array
     */
    public function postSave() {
        User::onlyHas('feed-edit');

        $id = Input::get('id');
        $general = Input::get('general');

        $feed = Feed::find($id);
        if ($feed) {
            $feed->name = $general['name'];
            $feed->enabled = isset($general['enabled']) ? 1 : 0;
            $feed->limit_type = $general['limit_type'];
            $feed->limit_value = $general['limit_value'];
            $feed->order_type = $general['order_type'];
            $feed->order_by = $general['order_by'];
            $feed->save();

            Log::info("Edit feed #{$id}");
        } else {
            throw new Exception("Undefined Feed #{$id} DATA: " . serialize($general));
        }


        return array();
    }

    public function postChangefeed() {
        User::onlyHas('feed-edit');

        $id = Input::get('id');
        $fields = Input::get('addfields');

        $exists = [];
        foreach (FeedField::get_($id) as $field) {
            $exists[$field->id] = $field;
        }

        // Insert inexistent fields
        foreach ($fields as $fieldId) {
            if (isset($exists[$fieldId]) == FALSE) {
                $newField = new FeedRel;
                $newField->feed_id = $id;
                $newField->feed_field_id = $fieldId;
                $newField->save();
            }
        }

        // Delete Existent fields
        foreach ($exists as $field) {
            if (in_array($field->id, $fields) == FALSE) {

                FeedRel::where('feed_field_id', $field->id)
                        ->where('feed_id', $id)
                        ->delete();

                FeedFieldValue::where('feed_field_id', $field->id)
                        ->whereIn('post_id', function($query) use ($id) {
                            $query->select(FeedPost::getField('post_id'))
                            ->from(FeedPost::getTableName())
                            ->where('feed_id', $id);
                        })->delete();
            }
        }

        return Illuminate\Support\Facades\Redirect::back();
    }

    /**
     * save post changes
     * @return array
     */
    public function postPostsave() {
        User::onlyHas('feedpost-edit');

        $id = Input::get('id');

        $response = array();

        // update Post record
        $general = Input::get('post');
        if ($general && $id) {
            $response['Post'] = 1;

            $post = Post::findTax($id, $this->taxonomy->id);
            $post->created_at = $general['created_at'];
            $post->to_home = isset($general['to_home']) ? 1 : 0;
            $post->show_pcomment = isset($general['show_pcomment']) ? 1 : 0;
            $post->have_comments = isset($general['have_comments']) ? 1 : 0;
            $post->have_socials = isset($general['have_socials']) ? 1 : 0;
            $post->is_alert = isset($general['is_alert']) ? 1 : 0;
            $post->alert_expire = $general['alert_expire'];

            if ($post->is_alert) {
                Post::where('is_alert', 1)->update(['is_alert' => 1]);
            }

            $post->save();

            Log::info("Edit Post (article) #{$id}");
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
        if ($dinamic_post_fields) {
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
        }

        return $response;
    }

    public function postLangpostsave() {
        User::onlyHas('feedpost-edit');

        $response = array();

        $id = Input::get('id');
        $lang_id = Input::get('lang_id');

        // update PostLang records
        $postlang = Input::get('postlang');
        if ($postlang) {
            $response['PostLang'] = 1;

            foreach ($postlang as $plang_id => $plang) {
                $post_lang = PostLang::find($plang_id);
                if ($post_lang) {
                    $post_lang->title = $plang['title'];
                    $post_lang->uri = PostLang::uniqURI($plang_id, $plang['uri'] ? $plang['uri'] : $plang['title']);
                    $post_lang->text = $plang['text'];
                    $post_lang->enabled = isset($plang['enabled']) ? 1 : 0;
                    $post_lang->save();

                    Log::info("Edit PostLang (article) #{$plang_id}");
                } else {
                    throw new Exception("Undefined PostLang #{$plang_id} DATA: " . serialize($plang));
                }
            }
        }

        // update dinamic lang fields
        $dinamic_lang_fields = Input::get("dinamic_lang.{$lang_id}");
        FeedFieldValue::where('post_id', $id)->where('lang_id', $lang_id)->delete();
        if (is_array($dinamic_lang_fields) && $dinamic_lang_fields) {
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
        }

        return $response;
    }

    /**
     * Get posts for jqgrid
     * @return json
     */
    public function postPosts($feed_id) {
        User::onlyHas('feedpost-view');

        Session::put('feed_id', $feed_id);

        $jqgrid = new jQgrid(Post::getTableName());
        $jqgrid->use_populate_count = true;
        echo $jqgrid->populate(function ($start, $limit) {
            $feed_id = Session::get('feed_id');
            $list = Post::prepareAll(true)
                    ->select(Post::getField('id'), PostLang::getField('title'), Post::getField('created_at'), Post::getField('views'))
                    ->where(Post::getField('taxonomy_id'), $this->taxonomy->id)
                    ->where(FeedPost::getField('feed_id'), $feed_id)
                    ->where(Post::getField('is_trash'), 0);

            if ($limit) {
                $list = $list->skip($start)->take($limit);
            }

            return $list->get($list);
        });
        $this->layout = null;
    }

    public function postAllfeeds() {
        User::onlyHas('feed-view');

        $jqgrid = new jQgrid(Feed::getTableName());
        $jqgrid->use_populate_count = true;
        return $jqgrid->populate(function ($start, $limit) {
                    $list = Feed::select('id', 'name', 'enabled')->orderBy('name', 'asc');

                    if ($limit) {
                        $list = $list->skip($start)->take($limit);
                    }

                    return $list->get($list);
                });
    }

    public function postAllposts() {
        User::onlyHas('feedpost-view');

        $jqgrid = new jQgrid(Post::getTableName());
        $jqgrid->use_populate_count = true;
        return $jqgrid->populate(function ($start, $limit) {
                    $list = Post::prepareAll()
                            ->select(Post::getField('id'), PostLang::getField('title'), Post::getField('created_at'), Post::getField('views'))
                            ->where(Post::getField('taxonomy_id'), $this->taxonomy->id)
                            ->where(Post::getField('is_trash'), 0);

                    if ($limit) {
                        $list = $list->skip($start)->take($limit);
                    }

                    $list = $list->get();

                    $newList = [];
                    foreach ($list as $item) {
                        $feeds = Feed::getPostFeeds($item->id);
                        $feeds_ar = [];
                        foreach ($feeds as $feed) {
                            $feeds_ar[] = $feed['name'];
                        }

                        $newList[] = [
                            'id' => $item->id,
                            'title' => $item->title,
                            'created_at' => $item->created_at,
                            'feeds' => implode(', ', $feeds_ar)
                        ];
                    }

                    return $newList;
                });
    }

    public function postAlltrash() {
        User::onlyHas('feedpost-view');

        $jqgrid = new jQgrid(Post::getTableName());
        $jqgrid->use_populate_count = true;
        return $jqgrid->populate(function ($start, $limit) {
                    $list = Post::prepareAll()
                            ->select(Post::getField('id'), PostLang::getField('title'), Post::getField('created_at'), Post::getField('views'))
                            ->where(Post::getField('taxonomy_id'), $this->taxonomy->id)
                            ->where(Post::getField('is_trash'), 1);

                    if ($limit) {
                        $list = $list->skip($start)->take($limit);
                    }

                    return $list->get($list);
                });
    }

    public function postPostattach() {
        User::onlyHas('feedpost-edit');

        $post = Post::find(Input::get('post_id'));
        $post->feed_id = Input::get('id');
        $post->save();
    }

    public function getTrash($id) {

        $post = Post::find($id);
        if ($post) {
            $post->is_trash = 1;
            $post->save();
        }

        Log::warning("Move to tash post #{$id}");

        return Redirect::to("feed/editpost/{$id}");
    }

    public function getRestore($id) {

        $post = Post::find($id);
        if ($post) {
            $post->is_trash = 0;
            $post->save();
        }

        Log::warning("Restore post #{$id}");

        return Redirect::to("feed/editpost/{$id}");
    }

    public function postDelete() {
        $id = Input::get('id');

        $post = Post::find($id);
        if ($post->is_trash == 1) {
            PostLang::where('post_id', $id)->delete();
            FeedFieldValue::where('post_id', $id)->delete();

            Files::dropMultiple('post_cover', $id);
            Files::dropMultiple('doc_post_lang', $id);
            Files::dropMultiple('doc_post', $id);

            $post->delete();

            Log::warning("Drop post #{$id}");
        }

        return Redirect::to('feed');
    }

    public function postDeletefeed() {
        $id = Input::get('id');

        Feed::where('id', $id)->delete();
        FeedPost::where('feed_id', $id)->delete();
        FeedRel::where('feed_id', $id)->delete();

        return Redirect::to('feed');
    }

}
