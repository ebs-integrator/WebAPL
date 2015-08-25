<?php

namespace WebAPL\Modules;


use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use WebAPL\Modules;
use WebAPL\Template;

use WebAPL\Actions,
    Route;


class Partners extends \WebAPL\ExtensionController
{
    protected $module_name = 'partners';
    protected $layout;

    public function __construct()
    {
        parent::__construct();

        Route::get('partners', array('before' => 'auth', array($this, 'view')));

        Event::listen('construct_left_menu', array($this, 'left_menu_item'));
        $this->layout = Template::mainLayout();
    }

    public function left_menu_item()
    {
            echo Template::moduleView($this->module_name, 'views.partners-left-menu');
    }
    public function view(){

        $this->layout->content = Template::moduleView($this->module_name, 'views.partners');
        return $this->layout;
    }


}