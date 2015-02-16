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
 


class SearchController extends BaseController {

    protected $layout = 'layout/page';

    public function results() {
        $keywords = Input::get('words');

        $this->data['words'] = strip_tags($keywords);
        $this->data['results'] = Post::search($keywords);

        if (count($this->data['results']) === 1) {
            return Illuminate\Support\Facades\Redirect::to(WebAPL\Language::url('topost/' . $this->data['results'][0]->id));
        }
        
        WebAPL\Template::setPageTitle("Search: {$this->data['words']}", true);

        PageController::loadGeneralResources();

        $this->layout->content = View::make('sections.search.results', $this->data);
    }

    public function topost($id) {

        $post = Post::find($id);

        if ($post) {
            switch ($post->taxonomy_id) {
                case 1:
                    $uri = Post::getFullURI($post->id, true);
                    return Redirect::to($uri);
                case 2:
                    $feed = FeedPost::where('post_id', $post->id)->first();
                    if ($feed) {
                        $page = Post::where('feed_id', $feed->feed_id)->first();
                        if ($page) {
                            $viewmods = WebAPL\Template::getViewMethodList('page');
                            $uri = Post::getFullURI($page->id, true);

                            if (isset($viewmods[$page->view_mod]['support_item']) && $viewmods[$page->view_mod]['support_item']) {
                                $plang = PostLang::where('post_id', $post->id)->where('lang_id', \WebAPL\Language::getId())->first();
                                if ($plang) {
                                    $url = $uri . "?item=" . $plang->uri;
                                } else {
                                    $url = $uri;
                                }
                            } else {
                                $url = $uri;
                            }

                            return Redirect::to($url);
                        } else {
                            throw new Exception("Not found page, post #{$id}");
                        }
                    } else {
                        throw new Exception("Not found feed, post #{$id}");
                    }
                    break;
                default:
                    throw new Exception("Not found taxonomy, post #{$id}");
                    break;
            }
        } else {
            throw new Exception("Post not found #{$id}");
        }
    }

    public function topage($modview) {
        $post = Post::where('view_mod', $modview)->first();

        if ($post) {
            $uri = Post::getFullURI($post->id, true);
            return Redirect::to($uri);
        } else {
            throw new Exception("Post not found #{$modview}");
        }
    }
    
    public function topropr($property) {
        $post = PostProperty::postWithProperty($property);

        if ($post) {
            $uri = Post::getFullURI($post->id, true);
            return Redirect::to($uri);
        } else {
            throw new Exception("Post not found #{$property}");
        }
    }

}
