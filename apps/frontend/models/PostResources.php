<?php

class PostResources {

    public static function init() {
        \Core\APL\Shortcodes::register('contact', array('PostResources', 'blockContact'));
    }

    public static function blockContact($params) {
        return View::make('sections.pages.blocks.contactDiv', $params);
    }
    

}
