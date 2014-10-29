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
    GalleryModel,
    Files,
        Event,
    GalleryPost;

class Gallery extends \Core\APL\ExtensionController {

    protected $module_name = 'gallery';

    /**
     * Init gallery module
     */
    public function __construct() {
        parent::__construct();

        $this->loadClass(array('GalleryModel', 'GalleryPost'));
        // Register actions
        Event::listen('page_bottom_container', array($this, 'page_bottom_gallery'));
        Event::listen('post_bottom_container', array($this, 'page_bottom_gallery'));
    }

    public function page_bottom_gallery($page) {
        $gallery = GalleryPost::where('post_id', $page['id'])->get()->first();

        if ($gallery) {
            $data = array(
                'list' => Files::file_list('gallery', $gallery->gallery_id),
            );

            echo Template::moduleView($this->module_name, 'views.page_gallery', $data);
        }
    }

}