<?php

class PageController extends BaseController {

    protected $layout;

    public function route($query = '') {
        $parts = explode('/', $query);
        if ($parts) {
            $uri = end($parts);
            $this->data['page'] = Post::findURI($uri);
            if ($this->data['page']) {
                
                Template::addBreadCrumb("/", "Home");
                
                $this->data['parents'] = Post::getParents($this->data['page']['parent']);
                $this->data['parent'] = Post::findID($this->data['page']['parent'], 1);
                $this->data['colevels'] = Post::findWithParent($this->data['page']['parent']);

                if ($this->data['page']->show_files) {
                    $this->data['page']['files'] = Files::where(array(
                                'module_name' => 'page',
                                'module_id' => $this->data['page']->id,
                                'type' => 'document'
                            ))->get();
                } else {
                    $this->data['page']['files'] = array();
                }
                
                $this->data['general_pages'] = Post::findGeneral();

                if ($this->data['parent']) {
                    $this->data['top_title'] = $this->data['parent']['title'];
                } else {
                    $this->data['top_title'] = $this->data['page']['title'];
                }

                $segments = array();
                foreach (array_reverse($this->data['parents']) as $parrent) {
                    $segments[] = $parrent['uri'];
                    Template::addBreadCrumb(Post::getURL(implode('/', $segments)), $parrent['title']);
                }
                $segments[] = $this->data['page']['uri'];
                Template::addBreadCrumb($this->data['page']['url'], $this->data['page']['title']);

                $realURI = implode('/', $segments);

                $this->data['page_url'] = Core\APL\Language::url("page/" . $realURI);

                if ($realURI === $query) {
                    Post::oneView($this->data['page']['id']);
                    
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

}
