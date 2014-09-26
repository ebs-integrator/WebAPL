<?php

class PageController extends BaseController {

    protected $layout;

    public function route($query = '') {
        $parts = explode('/', $query);
        if ($parts) {
            $uri = end($parts);
            $this->data['page'] = Post::findURI($uri);
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
                Template::addBreadCrumb("/", "Home");

                // Get pages resources
                $this->data['parents'] = Post::getParents($this->data['page']['parent']);
                $this->data['parent'] = Post::findID($this->data['page']['parent'], 1);
                $this->data['colevels'] = Post::findWithParent($this->data['page']['parent']);

                // get real page URI
                $segments = array();
                $parrents_ids = array();
                foreach (array_reverse($this->data['parents']) as $parrent) {
                    $segments[] = $parrent['uri'];
                    $parrents_ids[] = $parrent['id'];
                    Template::addBreadCrumb(Post::getURL(implode('/', $segments)), $parrent['title']);
                }
                $segments[] = $this->data['page']['uri'];
                Template::addBreadCrumb($this->data['page']['url'], $this->data['page']['title']);
                $realURI = implode('/', $segments);

                // Verify if real uri is correct
                if ($realURI === $query) {

                    // get global data
                    $this->data['general_pages'] = Post::findGeneral();
                    View::share(array(
                        'general_pages' => $this->data['general_pages'],
                        'active_page_id' => $this->data['page']->id,
                        'parrents_ids' => $parrents_ids,
                        'buttom_pages' => PostProperty::postsWithProperty('button_site', 3),
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

                    Core\APL\Template::setPageTitle($this->data['page']['title']);

                    $this->data['page_url'] = Core\APL\Language::url("page/" . $realURI);

                    // Get page files
                    if ($this->data['page']->show_files) {
                        $this->data['page']['files'] = Files::where(array(
                                    'module_name' => 'page',
                                    'module_id' => $this->data['page']->id,
                                    'type' => 'document'
                                ))->get();
                    } else {
                        $this->data['page']['files'] = array();
                    }

                    // register one view
                    Post::oneView($this->data['page']['id']);

                    // load page
                    if ($this->data['page']->general_node) {
                        return $this->loadHome();
                    } else {
                        return $this->loadPage();
                    }
                } else {
                    throw new Exception("Query '{$query}' is not valid");
                }
            } else {
                throw new Exception("Page with uri '{$uri}' not found");
            }
        } else {
            throw new Exception("No valid page URI");
        }
    }

    public function home() {
        $home_page = Post::where('is_home_page', 1)->first();

        if ($home_page) {
            return $this->route(Post::getFullURI($home_page->id, false));
        } else {
            throw new Exception("Undefined home page");
        }
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
        Core\APL\Language::setLanguage($ext);

        $redirectTo = Core\APL\Language::ext();
        if ($id) {
            $url = Post::getFullURI($id);
            if ($url) {
                $redirectTo = $url;
            }
        }

        return Redirect::to($redirectTo);
    }

}
