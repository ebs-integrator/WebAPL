<?php

// core fragment
class APL_Controller {
    
    protected function global_controller() {
        
    }
    
}

class APL_Action {
    
    protected function global_action() {
        
    }
    
}

class APL_ShortCode {
    
    protected function global_sortcode() {
        
    }
    
}
// end core


require_once 'module_example2.php';



// begin core


$action = new ReflectionClass('Comments\Actions');
$controller = new ReflectionClass('Comments\Controllers');
$shortcode = new ReflectionClass('Comments\ShortCodes');


$actions = $action->getMethods();
$controllers = $controller->getMethods();
$shortcodes = $shortcode->getMethods();


var_dump($actions, $controllers, $shortcodes);

// end core

