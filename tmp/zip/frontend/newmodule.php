<?php

namespace Core\APL\Modules;

use Core\APL\Actions;

class Newmodule extends \Core\APL\ExtensionController {

    public function __construct() {
        parent::__construct();

        Actions::get('newmodule', function () {
            echo "New Module enabled";
        });
    }
    
}