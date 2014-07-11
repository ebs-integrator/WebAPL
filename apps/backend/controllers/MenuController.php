<?php

class MenuController extends BaseController {

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
        $this->data['items'] = Menu::all();
        $this->layout->content = View::make('sections.menu.list')->with($this->data);
    }
    
    public function getItem($id = 0) {
        $this->data['menu'] = Menu::find($id);
        $this->layout->content = View::make('sections.menu.form')->with($this->data);
    }

    public function getAdd() {
        $this->layout->content = View::make('sections.menu.form')->with($this->data);
    }

    public function postSave() {
        
    }

}
