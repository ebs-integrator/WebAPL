<?php

class BaseController extends Controller {

    function __construct() {
    }

    protected function setupLayout() {
        
        Template::addBreadCrumb("/", "Home");
        
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}
