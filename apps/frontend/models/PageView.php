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
                $post = Post::findURI($item, 1);
            } else {
                $post = Post::postsFeed($data['page']->feed_id, false, true)->first();
            }

            if ($post) {
                $wdata["post"] = Post::withDinamicFields($post);
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

    public static function promisesPageMod($data) {

        Post::$taxonomy = 1;
        $wdata["posts"] = Post::findWithParent($data['page']->id);
        $data["page"]->text .= View::make("sections.pages.modview.promisePages")->with($wdata);

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

    public static function articleView($data) {
        $data['page']->text = \Core\APL\Shortcodes::execute($data['page']->text);

        return View::make('sections.pages.article')->with($data);
    }

    public static function contactsView($data) {
        $data['page']->text = \Core\APL\Shortcodes::execute($data['page']->text);

        return View::make('sections.pages.contacts')->with($data);
    }

    public static function homeView($data) {
        $data['page']->text = \Core\APL\Shortcodes::execute($data['page']->text);

        $data['page']['background'] = Files::getfile('page_bg', $data['page']->id);

        $data['sub_pages'] = Post::subPosts($data['page']->id, 2);
        $data['home_posts'] = Post::findHomePosts();

        return View::make('sections.pages.home')->with($data);
    }

    public static function fullView($data) {
        $data['page']->text = \Core\APL\Shortcodes::execute($data['page']->text);

        return View::make('sections.pages.fullw')->with($data);
    }

    public static function meetingPast($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];

            if ($item) {
                $wdata["post"] = Post::findURI($item, 1);
                if ($wdata["post"]) {
                    $wdata["post"] = Post::withDinamicFields($wdata["post"]);
                    $data["page"]->text .= View::make("sections.pages.modview.meetingFuture")->with($wdata);
                } else {
                    throw new Exception("Undefined post #{$item}");
                }
            } else {
                $posts_instance = Post::postsFeed($data['page']->feed_id, false, true)->where(Post::getField('created_at'), '<', DB::raw('CURRENT_TIMESTAMP'));
                $wdata["posts"] = Post::setFeedPagination($posts_instance, $data['page']->feed_id);
                $data["page"]->text .= View::make("sections.pages.modview.meetingPasts")->with($wdata);
            }
        }
        return static::defaultView($data);
    }

    public static function meetingFuture($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $wdata['post'] = Post::postsFeed($data['page']->feed_id, false, true)->where(Post::getField('created_at'), '>', DB::raw('CURRENT_TIMESTAMP'))->first();
            if ($wdata['post']) {
                $data["page"]->text = View::make("sections.pages.modview.meetingFuture")->with($wdata);
            } else {
                $data["page"]->text = "Nui";
            }
        }
        return static::defaultView($data);
    }

    public static function videoList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];

            if ($item) {
                $post = Post::findURI($item, 1);
            } else {
                $post = Post::postsFeed($data['page']->feed_id, false, true)->first();
            }

            if ($post) {
                $wdata["post"] = $post;
                $posts_instance = Post::postsFeed($data['page']->feed_id, false, true)->where(Post::getField('id'), '<>', $wdata["post"]->id);
                $wdata["posts"] = Post::setFeedPagination($posts_instance, $data['page']->feed_id);
                $data["page"]->text .= View::make("sections.pages.modview.video")->with($wdata);
            }
        }
        return static::defaultView($data);
    }

    public static function adsList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];

            $data['current_year'] = intval(Input::get('year'));
            $data['current_month'] = intval(Input::get('month'));

            if ($item) {
                $wdata["post"] = Post::findURI($item, 1);
            } else {
                $wdata["post"] = Post::applyDate(Post::postsFeed($data['page']->feed_id, false, true), $data['current_year'], $data['current_month'])->first();
            }

            $data['years_list'] = Feed::getYears($data['page']->feed_id);

            if ($wdata["post"]) {
                $data['current_year'] = date('Y', strtotime($wdata["post"]->created_at));
                $data['current_month'] = date('m', strtotime($wdata["post"]->created_at));

                $wdata["post"]->cover = Post::coverImage($wdata["post"]->id);

                $wdata['current_year'] = $data['current_year'];
                $wdata['current_month'] = $data['current_month'];

                $posts_instance = Post::postsFeed($data['page']->feed_id, false, true)->where(Post::getField('id'), '<>', $wdata["post"]->id);
                $wdata['posts'] = Post::setFeedPagination(Post::applyDate($posts_instance, $data['current_year'], $data['current_month']), $data['page']->feed_id);
            }
            $data["page"]->text .= View::make("sections.pages.modview.ads")->with($wdata);
        }
        return static::articleView($data);
    }

    public static function newsList($data) {
        if ($data['page']->feed_id) {
            Post::$taxonomy = 2;
            $item = Input::get('item');
            $wdata['page_url'] = $data['page_url'];

            $data['current_year'] = intval(Input::get('year'));
            $data['current_month'] = intval(Input::get('month'));

            if ($item) {
                $wdata["post"] = Post::findURI($item, 1);

                if ($wdata["post"]) {
                    $data['current_year'] = date('Y', strtotime($wdata["post"]->created_at));
                    $data['current_month'] = date('m', strtotime($wdata["post"]->created_at));

                    $wdata["post"]->cover = Post::coverImage($wdata["post"]->id);

                    $data["page"]->text .= View::make("sections.pages.modview.newsFull")->with($wdata);

                    return static::contactView($data);
                } else {
                    throw new Exception("Post not found");
                }
            } else {

                if (!$data['current_year'] || !$data['current_month']) {
                    $last = Post::postsFeed($data['page']->feed_id, false, true)->first();
                    if ($last) {
                        $data['current_year'] = date('Y', strtotime($last->created_at));
                        $data['current_month'] = date('m', strtotime($last->created_at));
                    } else {
                        throw new Exception("Posts not found");
                    }
                }

                $wdata['current_year'] = $data['current_year'];
                $wdata['current_month'] = $data['current_month'];
                $wdata['posts'] = Post::setFeedPagination(Post::applyDate(Post::postsFeed($data['page']->feed_id, false, true), $data['current_year'], $data['current_month']), $data['page']->feed_id);
                foreach ($wdata['posts'] as &$post) {
                    $post['cover'] = Post::coverImage($post->id);
                }

                $data["page"]->text .= View::make("sections.pages.modview.news")->with($wdata);
            }

            $data['years_list'] = Feed::getYears($data['page']->feed_id);
        }
        return static::articleView($data);
    }

    public static function mapPage($data) {

        $wdata['tree'] = Post::treePosts(0);

        $data['page']->text .= View::make('sections.pages.modview.map', $wdata);

        return static::fullView($data);
    }

    /**
     *    END PAGE VIEWS
     */
}
