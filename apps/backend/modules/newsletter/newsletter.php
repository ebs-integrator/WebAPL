<?php

namespace Core\APL\Modules;

use Core\APL\Actions;
use Core\APL\Template;
use Input;
use NewsletterModel;
use jQgrid;

class Newsletter extends \Core\APL\ExtensionController {

    protected $module_name = 'newsletter';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('NewsletterModel'));

        Actions::get('newsletter/settings', array('before' => 'auth', array($this, 'settings')));
        Actions::get('newsletter/list', array('before' => 'auth', array($this, 'email_list')));
        Actions::post('newsletter/getlist', array('before' => 'auth', array($this, 'getlist')));
        Actions::post('newsletter/edititem', array('before' => 'auth', array($this, 'edititem')));
        Actions::get('newsletter/send', array('before' => 'auth', array($this, 'send_message')));
        
        Actions::register('construct_left_menu', array($this, 'left_menu_item'));
        Actions::register('feed_post_bottom', array($this, 'sendemails'));

        $this->layout = Template::mainLayout();
    }

    public function settings() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.settings');

        return $this->layout;
    }

    public function left_menu_item() {
        if (\User::has('newsletter-view')) {
            echo Template::moduleView($this->module_name, 'views.newsletter-left-menu');
        }
    }

    public function email_list() {
        \User::onlyHas('newsletter-view');
        
        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function getlist() {
        \User::onlyHas('newsletter-view');
        
        $jqgrid = new jQgrid('apl_newsletter');
        echo $jqgrid->populate(function ($start, $limit) {
                    return NewsletterModel::select('id', 'email', 'subscribe_date', 'enabled')->skip($start)->take($limit)->get();
                });
    }

    public function edititem() {
        \User::onlyHas('newsletter-view');
        
        $jqgrid = new jQgrid('apl_newsletter');
        $jqgrid->operation(array(
            'email' => Input::get('email'),
            'enabled' => Input::get('enabled')
        ));
    }
    
    public function send_message() {
        \User::onlyHas('newsletter-view');
        
        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }
    
    public function sendemails($post) {
        
        return Template::moduleView($this->module_name, 'views.send_email');
    }

}