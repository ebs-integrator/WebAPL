<?php

class PageController extends BaseController {

    public function route($query = '') {
        $parts = explode('/', $query);
        if ($parts) {
            var_dump($parts);
            
        } else {
            throw new Exception("No valid page URI");
        }
    }

    public function prepareData() {
        
    }
    
    protected $layout = 'layout/page';
    public function markup($view) {
        $this->layout->content = View::make('markup/' . $view);

        return $this->layout;
    }
}