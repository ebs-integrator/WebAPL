<?php

class PageView {

    // INIT
    public static function run($data, $defaultView = 'defaultView') {
        if (isset($data['page']['view_mod']) && Core\APL\Template::checkViewMethod('page', $data['page']['view_mod'])) {
            return Core\APL\Template::callViewMethod('page', $data['page']['view_mod'], array($data));
        } else {
            return call_user_func(array('PageView', $defaultView), $data);
        }
    }

    /**
     *   PAGE VIEWS
     */
    public static function posturiVacante($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];

            if ($item) {
                $wdata["post"] = Post::findURI($item, 1);
            } else {
                $wdata["post"] = Post::postsFeed($data['page']->feed_id, false, true)->first();
            }

            if ($wdata["post"]) {
                $posts_instance = Post::postsFeed($data['page']->feed_id, false, true)->where(Post::getField('id'), '<>', $wdata["post"]->id);
                $wdata["posts"] = Post::setFeedPagination($posts_instance, $data['page']->feed_id);
                $data["page"]->text .= View::make("sections.pages.modview.vacansions")->with($wdata);
            }
        }
        return static::defaultView($data);
    }

    public static function acquisitionsList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];

            if ($item) {
                $post = Post::findURI($item, 1);
                if ($post) {
                    $wdata['post'] = Post::withDinamicFields($post);
                    $data["page"]->text .= View::make("sections.pages.modview.acquisition")->with($wdata);
                } else {
                    throw new Exception("Undefined article '{$item}'");
                }
            } else {
                $wdata["posts"] = Post::postsFeed($data['page']->feed_id, false);
                $data["page"]->text .= View::make("sections.pages.modview.acquisitionsList")->with($wdata);
            }
        }
        return static::defaultView($data);
    }
    
    public static function pollList($data) {
        
    }

    public static function projectsList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];

            if ($item) {
                $post = Post::findURI($item, 1);
                if ($post) {
                    $wdata["post"] = Post::withDinamicFields($post);
                    $wdata["post_files"] = Files::file_list('doc_post_lang', $wdata["post"]->post_lang_id);
                    $data["page"]->text .= View::make("sections.pages.modview.project")->with($wdata);
                } else {
                    throw new Exception("Undefined article '{$item}'");
                }
            } else {
                $wdata["posts"] = Post::postsFeed($data['page']->feed_id, false);
                $data["page"]->text .= View::make("sections.pages.modview.projectsList")->with($wdata);
            }
        }
        return static::defaultView($data);
    }

    public static function promisesMod($data) {
        if ($data['page']->feed_id) {
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];
            Post::$taxonomy = 2;
            if ($item) {
                $wdata['post'] = Post::findURI($item, 1);
                if ($wdata['post']) {
                    $data["page"]->text = View::make("sections.pages.modview.promise")->with($wdata);
                } else {
                    throw new Exception("Post not found");
                }
            } else {
                $wdata["posts"] = Post::postsFeed($data['page']->feed_id, true);
                $data["page"]->text .= View::make("sections.pages.modview.promises")->with($wdata);
            }
        }
        return static::defaultView($data);
    }

    public static function locationsList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata["feedPosts"] = Post::postsFeed($data['page']->feed_id, true);
            $data["page"]->text .= View::make("sections.pages.modview.locations")->with($wdata);
        }
        return static::defaultView($data);
    }

    public static function accordionList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata["feedPosts"] = Post::postsFeed($data['page']->feed_id);
            $data["page"]->text .= View::make("sections.pages.modview.accordion")->with($wdata);
        }
        return static::defaultView($data);
    }

    public static function tablePosts($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata["feedPosts"] = Post::postsFeed($data['page']->feed_id);
            $data["page"]->text .= View::make("sections.pages.modview.table")->with($wdata);
        }
        return static::defaultView($data);
    }

    public static function townList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata["feedPosts"] = Post::postsFeed($data['page']->feed_id, true);
            $data["page"]->text .= View::make("sections.pages.modview.towns")->with($wdata);
        }
        return static::defaultView($data);
    }

    public static function urgentNumbers($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata["feedPosts"] = Post::postsFeed($data['page']->feed_id, false);
            $data["page"]->text .= View::make("sections.pages.modview.urgent")->with($wdata);
        }
        return static::contactView($data);
    }

    public static function articleList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];
            if ($item) {
                $wdata['post'] = Post::findURI($item, 1);
                if ($wdata['post']) {
                    $wdata['post']['cover'] = Post::coverImage($wdata['post']->id);
                    $data["page"]->text = View::make("sections.pages.modview.articleFull")->with($wdata);
                } else {
                    throw new Exception("Post not found");
                }
            } else {
                $wdata["posts"] = Post::postsFeed($data['page']->feed_id, true);
                $data["page"]->text .= View::make("sections.pages.modview.articleList")->with($wdata);
            }
        }
        return static::defaultView($data);
    }

    public static function externLinks($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata["posts"] = Post::postsFeed($data['page']->feed_id, true);
            $data["page"]->text .= View::make("sections.pages.modview.links")->with($wdata);
        }
        return static::defaultView($data);
    }

    public static function fileFolders($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata["posts"] = Post::postsFeed($data['page']->feed_id, true);
            $data["page"]->text .= View::make("sections.pages.modview.folders")->with($wdata);
        }
        return static::defaultView($data);
    }

    public static function defaultView($data) {
        $data['page']->text = \Core\APL\Shortcodes::execute($data['page']->text);

        return View::make('sections.pages.default')->with($data);
    }

    public static function contactView($data) {
        $data['page']->text = \Core\APL\Shortcodes::execute($data['page']->text);

        return View::make('sections.pages.contact')->with($data);
    }

    public static function homeView($data) {
        $data['page']->text = \Core\APL\Shortcodes::execute($data['page']->text);

        $data['sub_pages'] = Post::subPosts($data['page']->id, 2);
        //var_dump($data['sub_pages']);  
        return View::make('sections.pages.home')->with($data);
    }

    /**
     *    END PAGE VIEWS
     */
}
