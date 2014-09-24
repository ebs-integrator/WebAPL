<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    FireChatSession;

class Firechat extends \Core\APL\ExtensionController {

    protected $module_name = 'firechat';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('FireChatSession'));

        Actions::get('firechat', array('before' => 'auth', array($this, 'view')));
        Actions::get('firechat/display', array('before' => 'auth', array($this, 'display')));
        Actions::register('construct_left_menu', array($this, 'left_menu_item'));
        
        $this->layout = Template::mainLayout();
    }

    public function view() {
        $data = array();
        
        $this->layout->content = Template::moduleView($this->module_name, 'views.chat-form', $data);

        return $this->layout;
    }
    
    public function display() {
        $data = array(
            'person' => \PersonModel::where('user_id', \Auth::user()->id)->first(),
        );
        
        if ($data['person']) {
            $data['person_lang'] = $data['person']->langs()->where('lang_id', \Core\APL\Language::getId())->first();
            
            return Template::moduleView($this->module_name, 'views.chat-display', $data);
        } else {
            throw new Exception('Person not found');
        }
        
        
    }
    
    public function left_menu_item() {
        echo Template::moduleView($this->module_name, 'views.chat-left-menu');
    }

}
