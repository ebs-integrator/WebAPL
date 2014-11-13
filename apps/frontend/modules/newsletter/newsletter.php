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
namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    Input,
    Validator,
    Route,
    Event,
    View,
    NewsletterModel;

class Newsletter extends \WebAPL\ExtensionController {

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
            'enabled' => 0
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
                    varlang('email') => Input::get('email')
                        ), array(
                    varlang('email') => 'email|required'
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
