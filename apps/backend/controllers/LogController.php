<?php

class LogController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
                    if (!Auth::check()) {
                        return Redirect::to('auth');
                    }
                });
    }

    protected $layout = 'layout.main';

    public function getIndex() {
        User::onlyHas('log-view');
        
        $this->data['list'] = LogModel::orderBy('event_date', 'desc')->get();

        $this->layout->content = View::make('sections.log.list', $this->data);
    }

}