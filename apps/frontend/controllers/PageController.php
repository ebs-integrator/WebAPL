<?php

class PageController extends BaseController {

    public function route($query = '') {
        $parts = explode('/', $query);
        if ($parts) {
            $uri = end($parts);
            $this->data['page'] = Post::findURI($uri);
            if ($this->data['page']) {
                $reversed_uris = array_slice(array_reverse($parts), 1, count($parts)-1);
                
                $this->data['parrents'] = Post::getParents($this->data['page']['parent']);

                $matchAll = true;
                foreach ($this->data['parrents'] as $k => $parrent) {
                    $matchAll = $matchAll && (isset($reversed_uris[$k]) && $reversed_uris[$k] == $parrent['uri']);
                }

                if ($matchAll) {
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
        echo 'page loaded';
    }

    protected $layout = 'layout/page';

    public function markup($view) {
        $this->layout->content = View::make('markup/' . $view);

        return $this->layout;
    }

}