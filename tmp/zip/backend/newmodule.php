<?php

namespace Core\APL\Modules;

use Core\APL\Actions;

class Newmodule extends \Core\APL\ModelController {

    public function __construct() {
        parent::__construct();

        Actions::get('newmodule', function () {
            echo "Backend New Module enabled";
        });
    }
    
}