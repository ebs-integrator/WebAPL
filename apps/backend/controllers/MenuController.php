<?php

/**
 * 
 * CMS WebAPL 1.0. Platform is a free open source software for creating an managing
 * their full with CMS integrated CMS system
 * 
 * Copyright (C) 2014 Enterprise Business Solutions SRL
 * 
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with
 * this program.  If not, see <http://www.gnu.org/licenses/>.
 * You can read the copy of GNU General Public License in english here 
 * 
 * For more details about CMS WebAPL 1.0 please contact Enterprise Business
 * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
 * email to office@ebs.md 
 * 
 */
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
