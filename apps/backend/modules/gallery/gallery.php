<?php

namespace Core\APL\Modules;

use Core\APL\Actions;
use Core\APL\Template;

class Gallery extends \Core\APL\ExtensionController {

    protected $module_name = 'gallery';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass('GalleryModel');

        Actions::get('gallery/settings', array('before' => 'auth', array($this, 'settings')));
        Actions::get('gallery/delete/{id}', array('before' => 'auth', array($this, 'gallery_delete')));
        Actions::get('gallery/edit/{id}', array('before' => 'auth', array($this, 'gallery_edit')));
        Actions::post('gallery/create', array('before' => 'auth', array($this, 'gallery_create')));
        Actions::post('gallery/save', array('before' => 'auth', array($this, 'gallery_save')));
        Actions::get('gallery/list', array('before' => 'auth', array($this, 'gallery_list')));
        
        Actions::register('construct_left_menu', array($this, 'left_menu_item'));
        
        $this->layout = Template::mainLayout();
    }

    public function settings() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.settings');

        return $this->layout;
    }

    public function gallery_list() {
        $this->data['list'] = \GalleryModel::all();

        $this->layout->content = Template::moduleView($this->module_name, 'views.list', $this->data);
        return $this->layout;
    }

    public function gallery_create() {
        $gallery = new \GalleryModel;
        $gallery->name = \Input::get('name');
        $gallery->save();

        return \Redirect::to('gallery/edit/' . $gallery->id);
    }

    public function gallery_delete($id) {
        \GalleryModel::find($id)->delete();
        \Files::dropMultiple('gallery', $id);
        
        return \Redirect::to('gallery/list');
    }

    public function gallery_edit($id) {
        $this->data['gallery'] = \GalleryModel::find($id);

        $this->layout->content = Template::moduleView($this->module_name, 'views.form', $this->data);
        return $this->layout;
    }
    
    public function gallery_save() {
        $id = \Input::get('id');
        $gallery = \Input::get('gallery');
        
        $post = \GalleryModel::find($id);
        $post->name = $gallery['name'];
        $post->save();
    }
    
    public function left_menu_item() {
        echo Template::moduleView($this->module_name, 'views.left-menu-item');
    }

}