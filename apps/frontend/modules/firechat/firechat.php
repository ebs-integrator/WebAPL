<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    PersonModel,
    PersonLangModel,
    FireChatSession;

class Firechat extends \Core\APL\ExtensionController {

    protected $module_name = 'firechat';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('FireChatSession'));

        $this->loadClass(array('PersonModel', 'PersonLangModel'), 'person');

        Actions::get('firechat/display', array($this, 'display'));
        Actions::post('firechat/register', array($this, 'register'));

        Actions::register('bottom_contructor', array($this, 'popup'));
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

    public function popup() {
        $session_id = \Session::get('chat_session_id');
        if ($session_id) {
            $data['chat'] = \FireChatSession::find($session_id);
            if ($data['chat']) {
                if ($data['chat']->active) {
                    
                }
            }
        }

        $data = array(
            'persons' => PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField('person_id'), '=', PersonModel::getField('id'))
                    ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('last_name'))
                    ->orderBy(PersonLangModel::getField('first_name'))
                    ->where(PersonModel::getField('for_audience'), 1)
                    ->where(PersonLangModel::getField('lang_id'), \Core\APL\Language::getId())
                    ->get()
        );

        echo Template::moduleView($this->module_name, 'views.chat-popup', $data);
    }

    public function register() {
        $person_id = \Input::get('person_id');
        $name = \Input::get('name');
        $email = \Input::get('email');



        $person = PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField('person_id'), '=', PersonModel::getField('id'))
                ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('last_name'))
                ->orderBy(PersonLangModel::getField('first_name'))
                ->where(PersonModel::getField('for_audience'), 1)
                ->where(\PersonModel::getField('id'), $person_id)
                ->where(PersonLangModel::getField('lang_id'), \Core\APL\Language::getId())
                ->first();
        if ($person) {

            $item = new \FireChatSession;
            $item->user_email = $email;
            $item->user_name = $name;
            $item->person_id = $person_id;

            \Session::put('chat_session_id', $item->id);
            
            return array(
                'error' => 0,
                'person' => $person,
                'html' => Template::moduleView($this->module_name, 'views.chat-iframe', array(
                    'person' => $person,
                    'chat' => $item
                ))
            );
        } else {
            return array(
                'error' => 1
            );
        }
    }

}
