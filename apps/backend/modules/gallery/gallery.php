<?php

/**
 * 
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    Input,
    GalleryPost,
    Files,
    Redirect,
    Route,
    Event,
    GalleryModel;

class Gallery extends \Core\APL\ExtensionController {

    protected $module_name = 'gallery';
    protected $layout;

    /**
     * Init gallery module
     */
    public function __construct() {
        parent::__construct();

        $this->loadClass(array('GalleryModel', 'GalleryPost'));

        Route::get('gallery/settings', array('before' => 'auth', array($this, 'settings')));
        Route::get('gallery/delete/{id}', array('before' => 'auth', array($this, 'gallery_delete')));
        Route::get('gallery/edit/{id}', array('before' => 'auth', array($this, 'gallery_edit')));
        Route::post('gallery/create', array('before' => 'auth', array($this, 'gallery_create')));
        Route::post('gallery/save', array('before' => 'auth', array($this, 'gallery_save')));
        Route::get('gallery/list', array('before' => 'auth', array($this, 'gallery_list')));
        Route::post('gallery/save_post_attach', array('before' => 'auth', array($this, 'save_post_attach')));

        // Register actions
        Event::listen('construct_left_menu', array($this, 'left_menu_item'));
        Event::listen('page_attachment', array($this, 'page_attachment'));

        $this->layout = Template::mainLayout();
    }

    /**
     * Gallery settings page
     * @return layout
     */
    public function settings() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.settings');

        return $this->layout;
    }

    /**
     * List of galleries
     * @return layout
     */
    public function gallery_list() {
        \User::onlyHas('gallery-view');

        $this->data['list'] = GalleryModel::all();

        $this->layout->content = Template::moduleView($this->module_name, 'views.list', $this->data);
        return $this->layout;
    }

    /**
     * Create new gallery
     * @return Redirect
     */
    public function gallery_create() {
        \User::onlyHas('gallery-view');

        $gallery = new GalleryModel;
        $gallery->name = Input::get('name');
        $gallery->save();

        return Redirect::to('gallery/edit/' . $gallery->id);
    }

    /**
     * Detele gallery
     * @param int $id
     * @return Redirect
     */
    public function gallery_delete($id) {
        \User::onlyHas('gallery-view');

        GalleryModel::find($id)->delete();
        // Drop files for this gallery
        Files::dropMultiple('gallery', $id);

        return Redirect::to('gallery/list');
    }

    /**
     * edit existent gallery
     * @param int $id
     * @return layout
     */
    public function gallery_edit($id) {
        \User::onlyHas('gallery-view');

        $this->data['gallery'] = GalleryModel::find($id);

        $this->layout->content = Template::moduleView($this->module_name, 'views.form', $this->data);
        return $this->layout;
    }

    /**
     * Save gallery changes
     * ajax
     */
    public function gallery_save() {
        \User::onlyHas('gallery-view');

        $id = Input::get('id');
        $gallery = Input::get('gallery');

        $post = GalleryModel::find($id);
        $post->name = $gallery['name'];
        $post->save();
    }

    /**
     * Left menu Action
     */
    public function left_menu_item() {
        if (\User::has('gallery-view')) {
            echo Template::moduleView($this->module_name, 'views.gallery-left-menu');
        }
    }

    /**
     * Page attachment Action
     * @param Post $page
     */
    public function page_attachment($page) {
        if (\User::has('gallery-view')) {
            $post = $page->toArray();
            $this->data['page'] = $post;
            $this->data['list'] = GalleryModel::all();
            $this->data['selected'] = GalleryPost::where('post_id', $post['id'])->first();
            echo Template::moduleView($this->module_name, 'views.attachment', $this->data);
        }
    }

    /**
     * Ajax save page attachment
     */
    public function save_post_attach() {
        \User::onlyHas('gallery-view');

        $id = Input::get('id');
        $post_id = Input::get('post_id');

        GalleryPost::where('post_id', $post_id)->delete();

        if ($id && $post_id) {
            $record = new GalleryPost;
            $record->gallery_id = $id;
            $record->post_id = $post_id;
            $record->save();
        }
    }

}
