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
        Actions::post('firechat/newroom', array($this, 'newroom'));
        Actions::post('firechat/close', array($this, 'closesession'));

        Actions::post('firechat/getform', array($this, 'getform'));
        Actions::post('firechat/sendmail', array($this, 'sendmail'));

        Actions::register('bottom_contructor', array($this, 'popup'));
        Actions::register('logo_contructor', array($this, 'topbutton'));
        Actions::register('contact_col1_contructor', array($this, 'contactbutton'));
    }
    
    protected static $isOnline = 0;
    public static function online() {
        if (is_bool(static::$isOnline)) {
            return static::$isOnline;
        } else {
            static::$isOnline = PersonModel::where(PersonModel::getField('for_audience'), 1)->count() > 0;
            return static::$isOnline;
        }
    }

    public function display() {

        $session_id = \Session::get('chat_session_id');

        if ($session_id) {

            $data = array(
                'chat' => \FireChatSession::where('id', $session_id)->where('active', 1)->first(),
            );

            if ($data['chat']) {
                return Template::moduleView($this->module_name, 'views.chat-display', $data);
            }
        }

        throw new \Exception('Chat session not exist');
    }

    public function newroom() {
        $session_id = \Session::get('chat_session_id');

        $roomId = \Input::get('roomId');
        $userId = \Input::get('userId');

        if ($session_id) {
            $item = FireChatSession::find($session_id);
            $item->roomId = $roomId;
            $item->userId = $userId;
            $item->save();
        }

        return [];
    }

    public function popup() {
        $session_id = \Session::get('chat_session_id');


        $data = array(
            'persons' => PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField('person_id'), '=', PersonModel::getField('id'))
                    ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('last_name'))
                    ->orderBy(PersonLangModel::getField('first_name'))
                    ->where(PersonModel::getField('for_audience'), 1)
                    ->where(PersonLangModel::getField('lang_id'), \Core\APL\Language::getId())
                    ->get(),
            'session_exist' => false
        );

        if ($session_id) {
            $data['chat'] = \FireChatSession::find($session_id);
            if ($data['chat']) {
                if ($data['chat']->active) {
                    $data['session_exist'] = true;
                    $data['person'] = PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField('person_id'), '=', PersonModel::getField('id'))
                            ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('last_name'))
                            ->orderBy(PersonLangModel::getField('first_name'))
                            ->where(PersonModel::getField('for_audience'), 1)
                            ->where(\PersonModel::getField('id'), $data['chat']->person_id)
                            ->where(PersonLangModel::getField('lang_id'), \Core\APL\Language::getId())
                            ->first();
                    $data['person_icon'] = \Files::getfile('person_chat', $data['chat']->person_id);
                }
            }
        }

        echo Template::moduleView($this->module_name, 'views.chat-popup', $data);
    }

    public function topbutton() {

        $data = array(
            'online' => Firechat::online()
        );

        echo Template::moduleView($this->module_name, 'views.chat-button', $data);
    }
    
    public function contactbutton() {

        $data = array(
            'online' => Firechat::online()
        );

        echo Template::moduleView($this->module_name, 'views.chat-big-button', $data);
    }

    public function register() {
        $person_id = \Input::get('person_id');
        $name = \Input::get('name');
        $email = \Input::get('email');



        $person = PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField('person_id'), '=', PersonModel::getField('id'))
                ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('last_name'))
                ->where(PersonModel::getField('for_audience'), 1)
                ->where(PersonModel::getField('id'), $person_id)
                ->where(PersonLangModel::getField('lang_id'), \Core\APL\Language::getId())
                ->first();
        if ($person) {

            $item = new \FireChatSession;
            $item->user_email = $email;
            $item->user_name = $name;
            $item->person_id = $person_id;
            $item->save();

            $photo = \Files::getfile('person_chat', $person->id);
            if ($photo) {
                $person['photo'] = $photo->path;
            } else {
                $person['photo'] = '';
            }


            \Session::put('chat_session_id', $item->id);

            return array(
                'error' => 0,
                'person' => $person,
                'chat' => $item,
                'html' => Template::moduleView($this->module_name, 'views.chat-iframe', array(
                    'person' => $person,
                    'chat' => $item
                ))->render()
            );
        } else {
            return array(
                'error' => 1
            );
        }
    }

    public function closesession() {
        $session_id = \Session::get('chat_session_id');

        if ($session_id) {
            $chat = \FireChatSession::find($session_id);
            if ($chat) {
                $chat->active = 0;
                $chat->save();
            }
        }
    }

    public function getform() {
        $this->closesession();

        $id = \Input::get('id');

        $data = array(
            'persons' => PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField('person_id'), '=', PersonModel::getField('id'))
                    ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('last_name'))
                    ->orderBy(PersonLangModel::getField('first_name'))
                    ->where(PersonModel::getField('for_audience'), 1)
                    ->where(PersonLangModel::getField('lang_id'), \Core\APL\Language::getId())
                    ->get()
        );

        if ($id) {
            $data['person_selected'] = $id;
        }


        return Template::moduleView($this->module_name, 'views.chat-form', $data);
    }

    public function sendmail() {
        $session_id = \Session::get('chat_session_id');

        $html = \Input::get('messages');

        if ($session_id) {
            $chat = \FireChatSession::find($session_id);
            if ($chat) {
                $data['html'] = $html;
                Template::viewModule($this->module_name, function () use ($data, $chat) {
                    \Mail::send('views.email-mess', $data, function($message) use ($chat) {
                        $message->from("noreply@{$_SERVER['SERVER_NAME']}", 'Firechat');
                        $message->subject("Recent chat messages");
                        $message->to($chat->user_email);
                    });
                });
            }
        }
    }

}
