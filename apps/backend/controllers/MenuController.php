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
        $this->data['menuItems'] = Menu::treeItems($id);
        
        Event::listen('create_menu_items_form', array($this, 'itemsAddLink'));
        Event::listen('create_menu_items_form', array($this, 'itemsAddPage'));
        Event::listen('create_menu_items_form', array($this, 'itemsAddCategory'));
        
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
    
    public function postDrop() {
        $id = Input::get('id');
        
        Menu::drop($id);
        
        return array();
    }
    
    /** 
     * Add menu link
     */
    public function itemsAddLink() {
        echo View::make('sections.menu.block-add-link');
    }
    
    public function postAddlink() {
        $menu_id = Input::get('id');
        $link = Input::get('link');
        
        MenuItem::insertLinkItem($menu_id, $link);
        
        return array(
            'success' => 1
        );
    }
    
    public function itemsAddPage() {
        echo View::make('sections.menu.block-add-page');
    }
    
    public function itemsAddCategory() {
        echo View::make('sections.menu.block-add-category');
    }
    
    /**
     * Save tree order
     */
    public function postSavetree() {
        $tree = Input::get('tree');
        
        Menu::updateTree($tree);
        
        return array();
    }
    
    public function postGettree() {
        $id = Input::get('menu_id');
        $this->data['items'] = Menu::treeItems($id);
        return View::make('sections.menu.block-treeview')->with($this->data);
    }
    
    public function postDeletenode() {
        $node_id = Input::get('id');
        if ($node_id) {
            MenuItem::deleteNode($node_id);
        }
        return array();
    }
    
    public function postEditnode() {
        $node_id = Input::get('id');
        
        $this->data['item'] = MenuItem::find($node_id);
        $this->data['items_lang'] = MenuItemLang::where('menu_item_id', $node_id)->get();
        

        return View::make('sections.menu.block-edit-node')->with($this->data);
    }
    
    public function postSavenode() {
        MenuItemLang::updateNode(Input::get('nodelang'));
        
        return array();
    }


}
