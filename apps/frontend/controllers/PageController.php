<?php

class PageController extends BaseController {

    protected $layout = 'layout/page';

    public function route($query = '') {
        $parts = explode('/', $query);
        if ($parts) {
            $uri = end($parts);
            $this->data['page'] = Post::findURI($uri);
            if ($this->data['page']) {

                Post::oneView($this->data['page']['id']);
                
                $this->data['parents'] = Post::getParents($this->data['page']['parent']);
                $this->data['parent'] = Post::findID($this->data['page']['parent'], 1);
                $this->data['colevels'] = Post::findWithParent($this->data['page']['parent']);
                
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
                if ($realURI === $query) {
                    $this->loadPage();
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
        $this->layout->content = PageView::run($this->data);
 
        return $this->layout;
    }

    public function markup($view) {
        $this->layout->content = View::make('markup/' . $view);

        return $this->layout;
    }

}