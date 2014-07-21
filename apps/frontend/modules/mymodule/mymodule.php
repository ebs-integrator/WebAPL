<?php

namespace Core\APL\Modules;

use Core\APL\Actions;
use Core\APL\Shortcodes;
use Core\APL\Template;

require_once 'incfile.php';

class Mymodule extends \Core\APL\ExtensionController {

    public function __construct() {
        parent::__construct();

        Actions::get('qwe/{id?}', array($this, 'mycontr'));

        test_func();
    }

    public function mycontr($id = 0) {
        echo Shortcodes::execute("wqerqw [ext_name id='1'] {$id}  erqew r");
        
        return Template::moduleView('mymodule', 'views/myview');
    }

    public function myshorcode_extname($atr) {
        return 'EXT[' . \Module::find($atr['id'])->name . ']';
    }

}
