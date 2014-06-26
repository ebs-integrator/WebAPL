<?php

namespace Core\APL\Modules;

use Core\APL\Actions;

class Mymodule extends \Core\APL\ModelController {

    public function __construct() {
        parent::__construct();
        
        Actions::get('qwe/{id?}', array($this, 'mycontr'));
    }
    
    public function mycontr($id = 0) {
        echo Shortcodes::execute("wqerqw [ext_name id='1']  erqew r");
    }
    

}