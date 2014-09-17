<?php

namespace Core\APL\Modules;

use Core\APL\Actions;
use Core\APL\Template;
use Input, Validator;
use NewsletterModel;

class Newsletter extends \Core\APL\ExtensionController {

    protected $module_name = 'newsletter';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('NewsletterModel'));

        Actions::post('newsletter/subscribe', array($this, 'subscribe'));
        Actions::register('bottom_widgets', array($this, 'widget'));
    }

    public function widget() {
        return Template::moduleView($this->module_name, 'views.newsletter-subscribe');
    }

    public function subscribe() {

        $validator = Validator::make(array(
                    'email' => Input::get('email')
                        ), array(
                    'email' => 'email|required'
        ));

        $return = array(
            'message' => '',
            'error' => 0
        );

        if ($validator->fails()) {
            $return['message'] = implode(', ', $validator->messages()->all(':message'));
            $return['error'] = 1;
        } else {
            $newsletter = new NewsletterModel;
            $newsletter->email = Input::get('email');
            $newsletter->hash = sha1(Input::get('email') . time());
            $newsletter->save();
        }

        return $return;
    }

}
