<?php

namespace Core\APL\Modules;

use Core\APL\Actions;

class Newmodule extends \Core\APL\ExtensionController {

    public function __construct() {
        parent::__construct();

        \Route::get('newmodule', function () {
            echo "Backend New Module enabled";
        });
    }
    
}