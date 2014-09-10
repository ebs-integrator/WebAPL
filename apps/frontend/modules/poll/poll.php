<?php

/**
 * 
 *
 * @author     Victor Vlas <victor.vlas@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    PollModel,
    Input,
    PollAnswerModel,
    PollQuestionModel,
    Language,
    Redirect;

class Poll extends \Core\APL\ExtensionController {

    protected $module_name = 'poll';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('PollModel'));
    }

}
