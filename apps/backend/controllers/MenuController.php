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
    
    public function getOpen($id = 0) {
        $this->data['menu'] = Menu::find($id);
        
        View::share($this->data);
        $this->layout->content = View::make('sections.menu.form');
    }

    public function getAdd() {
        $this->layout->content = View::make('sections.menu.form')->with($this->data);
    }

    public function postSave() {
        $id = Input::get('id');
        
        $menu = Input::get('menu');
        $menu['enabled'] = isset($menu['enabled']) ? 1 : 0;
        
        if ($id) {
            Menu::updateArray($menu, $id);
        } else {
            Menu::insertArray($menu);
        }
        
        return Redirect::to('menu');
    }

}
