<?php

class HomeController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';


    public function showDashboard() {
        $this->layout->content = View::make('hello');
    }

    public function showPage() {
        echo 'test backend';
    }

}
