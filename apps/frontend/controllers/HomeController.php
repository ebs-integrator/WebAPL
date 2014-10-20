<?php

class HomeController extends BaseController {

    protected $layout = 'layout/home';

    public function clearcache() {
        Cache::flush();

        $this->layout->content = 'Access denied';

        return $this->layout;
    }

}
