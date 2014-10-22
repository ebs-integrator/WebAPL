<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    Input,
    Validator,
    Route,
    Event,
    View,
    NewsletterModel;

class Newsletter extends \Core\APL\ExtensionController {

    protected $module_name = 'newsletter';
    protected $layout;
    public static $view_widget = 'newsletter::newsletter-subscribe';
    public static $view_unsub = 'newsletter::newsletter-unsubscribe';

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('NewsletterModel'));

        Route::post('newsletter/subscribe', array($this, 'subscribe'));
        Route::get('newsletter/unsubscribe/{code}', array($this, 'unsubscribe'))->where(array('code' => '[A-Za-z0-9]+'));

        Event::listen('bottom_widgets', array($this, 'widget'));

        View::addNamespace('newsletter', app_path('/modules/newsletter/views'));
    }

    public function widget() {
        echo View::make(Newsletter::$view_widget);
    }

    public function unsubscribe($code) {

        \NewsletterModel::where('hash', $code)->update(array(
            'enabled' => 1
        ));

        return (new \PageController)->createPageFrom(function () {

                    Template::setPageTitle('Newsletter');
                    Template::clearBreadCrumbs();
                    Template::addBreadCrumb('/', 'Home');
                    Template::addBreadCrumb('#', 'Newsletter');
                    return View::make(Newsletter::$view_unsub);
                });
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
