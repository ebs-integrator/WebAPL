<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Shortcodes,
    Core\APL\Template;

class Socialcomplaints extends \Core\APL\ExtensionController {

    protected $module_name = 'socialcomplaints';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array(
            'SComplaintsModel'
        ));

        // Set settings page
        Shortcodes::register('scomplaint', array());
        
        Template::registerViewMethod('page', 'secial_complaints_list', 'Lista cu plingeri', null, true);


        // Set layout
        $this->layout = Template::mainLayout();
    }

}
