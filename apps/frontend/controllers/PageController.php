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
 



class PageController extends BaseController {

    protected $layout;

    public function route($query = '') {
        $parts = explode('/', $query);
        if ($parts) {
            $uri = end($parts);
            $this->data['page'] = Post::findURI($uri, 1);
            if ($this->data['page']) {
                PostResources::init();

                // Verify if page is redirectable
                if ($this->data['page']->redirect_to) {
                    $redirect_url = Post::getFullURI($this->data['page']->redirect_to);
                    if ($redirect_url) {
                        return Redirect::to($redirect_url);
                    }
                }
                // Verify if page is redirectable
                if ($this->data['page']->redirect_to) {
                    $redirect_url = Post::getFullURI($this->data['page']->redirect_to);
                    if ($redirect_url) {
                        return Redirect::to($redirect_url);
                    }
                }

                Template::clearBreadCrumbs();
                Template::addBreadCrumb("/", varlang('acasa'));

                // Get pages resources
                $this->data['parents'] = Post::getParents($this->data['page']['parent'], 1);
                $this->data['parent'] = Post::findID($this->data['page']['parent'], 1);
                $this->data['colevels'] = Post::findWithParent($this->data['page']['parent']);
                $this->data['super_parent'] = array_first($this->data['parents'], function ($key, $item) {
                    return $item['parent'] == 0;
                });
                
                // get real page URI
                $segments = array();
                $parrents_ids = array($this->data['page']->id);
                foreach (array_reverse($this->data['parents']) as $parrent) {
                    $segments[] = $parrent['uri'];
                    $parrents_ids[] = $parrent['id'];
                    Template::addBreadCrumb(Post::getURL(implode('/', $segments)), $parrent['title']);
                }
                $segments[] = $this->data['page']['uri'];
                Template::addBreadCrumb(Post::getURL($query), $this->data['page']['title']);
                $realURI = implode('/', $segments); 

                // Verify if real uri is correct
                if ($realURI === $query) {

                    // get global data
                    View::share(array(
                        'active_page_id' => $this->data['page']->id,
                        'parrents_ids' => $parrents_ids,
                        'super_parent' => $this->data['super_parent']
                    ));

                    // Verify if this page is clone
                    if ($this->data['page']->clone_id) {
                        $clone = Post::findID($this->data['page']->clone_id, 1);
                        if ($clone) {
                            $this->data['page'] = $clone;
                        }
                    }

                    // Set page title
                    $this->data['top_title'] = $this->data['page']['title'];

                    WebAPL\Template::setPageTitle($this->data['page']['title']);

                    $this->data['page_url'] = WebAPL\Language::url("page/" . $realURI);

                    // Get page files
                    if ($this->data['page']->show_files) {
                        $this->data['page']['files'] = Files::where(array(
                                    'module_name' => 'page',
                                    'module_id' => $this->data['page']->id,
                                    'type' => 'document'
                                ))->remember(SettingsModel::one('cachelife'))->get();
                    } else {
                        $this->data['page']['files'] = array();
                    }

                    // register one view
                    Post::oneView($this->data['page']['id']);

                    Template::setMetaMultiple(array(
                        'og:title' => $this->data['page']->title,
                        'description' => $this->data['page']->text,
                        'og:description' => $this->data['page']->text
                            ), true);

                    // load page
                    PageController::loadGeneralResources();
                    View::share('page', $this->data['page']);
                    if ($this->data['page']->general_node) {
                        return $this->loadHome();
                    } else {
                        return $this->loadPage();
                    }
                } else {
                    throw new Exception("Query '{$query}' is not valid", 404);
                }
            } else {
                throw new Exception("Page with uri '{$uri}' not found", 404);
            }
        } else {
            throw new Exception("No valid page URI", 404);
        }
    }

    public function home() {
        $home_page = Post::where('is_home_page', 1)->first();

        if ($home_page) {
            return $this->route(Post::getFullURI($home_page->id, false));
        } else {
            throw new Exception("Undefined home page", 404);
        }
    }

    public static function loadGeneralResources() {
        $data = array(
            'general_pages' => Post::findGeneral(),
            'buttom_pages' => PostProperty::postsWithProperty('button_site', 3),
            'favicon' => Files::getfile('website_favicon', 1),
            'alert_post' => Post::findAlertPost()
        );

        Template::setMetaMultiple(array(
            'og:type' => 'page',
            'og:image' => Files::extract('website_logo_' . WebAPL\Language::ext(), 1, 'path'),
            'og:site_name' => SettingsModel::one('sitename')
        ));

        View::share($data);
    }

    public function createPageFrom($function) {
        $this->layout = 'layout/page';
        $this->setupLayout();

        PageController::loadGeneralResources();

        $this->layout->content = call_user_func($function);

        return $this->layout;
    }

    public function loadPage() {
        $this->layout = 'layout/page';
        $this->setupLayout();

        $this->layout->content = PageView::run($this->data, 'defaultView');

        return $this->layout;
    }

    public function loadHome() {
        $this->layout = 'layout/home';
        $this->setupLayout();

        $this->layout->content = PageView::run($this->data, 'homeView');

        return $this->layout;
    }

    public function changeLanguage($ext, $id = 0) {
        WebAPL\Language::setLanguage($ext);

        $redirectTo = WebAPL\Language::ext();
        if ($id) {
            $url = Post::getFullURI($id);
            if ($url) {
                $redirectTo = $url;
            }
        }

        return Redirect::to($redirectTo);
    }

}
