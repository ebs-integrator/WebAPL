<?php

class BaseController extends Controller {

    protected $data = array();
            
    function __construct() {
        
    }

    protected function setupLayout() {
        if (!is_null($this->layout) && isset($this->layout->content)) {
            $this->layout = View::make($this->layout);
        } else {
            $this->layout = null;
        }
    }

}
