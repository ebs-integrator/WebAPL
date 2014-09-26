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
        
        $this->data['list'] = LogModel::leftJoin(User::getTableName(), User::getField('id'), '=', LogModel::getField('user_id'))->orderBy('event_date', 'desc')->take(100)->get();

        $this->layout->content = View::make('sections.log.list', $this->data);
    }

}