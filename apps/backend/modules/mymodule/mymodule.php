<?php

namespace Core\APL\Modules;

use Core\APL\Actions;
use Core\APL\Template;

class Mymodule extends \Core\APL\ExtensionController {

    public function __construct() {
        parent::__construct();
        
        Actions::get('qwe/{id?}', array($this, 'mycontr'));
        Actions::get('mymodule/settings', array($this, 'settings'));
    }
    
    protected $layout = 'layout.main';


    public function settings() {
        $layout = Template::mainLayout();
        
        $layout->content = Template::moduleView('mymodule', 'views.settings');
        
        return $layout;
    }
    
    public function mycontr($id = 0) {
       echo 'Tralala';
    }
    
    public static function edit() {
        
    }

}