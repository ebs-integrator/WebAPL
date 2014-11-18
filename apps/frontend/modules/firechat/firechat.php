<?php 
 
 /**
  * 
  * CMS Platform WebAPL 1.0 is a free open source software for creating and managing
  * a web site for Local Public Administration institutions. The platform was
  * developed at the initiative and on a concept of USAID Local Government Support
  * Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
  * The opinions expressed on the website belong to their authors and do not
  * necessarily reflect the views of the United States Agency for International
  * Development (USAID) or the US Government.
  * 
  * This program is free software: you can redistribute it and/or modify it under
  * the terms of the GNU General Public License as published by the Free Software
  * Foundation, either version 3 of the License, or any later version.
  * This program is distributed in the hope that it will be useful, but WITHOUT ANY
  * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  * PARTICULAR PURPOSE. See the GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License along with
  * this program. If not, you can read the copy of GNU General Public License in
  * English here: <http://www.gnu.org/licenses/>.
  * 
  * For more details about CMS WebAPL 1.0 please contact Enterprise Business
  * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
  * email to office@ebs.md 
  * 
  **/
 
namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    PersonModel,
    PersonLangModel,
        Route,
        Event,
    FireChatSession;

class Firechat extends \WebAPL\ExtensionController {

    protected $module_name = 'firechat';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('FireChatSession'));

        $this->loadClass(array('PersonModel', 'PersonLangModel'), 'person');

        Route::get('firechat/display', array($this, 'display'));
        Route::post('firechat/register', array($this, 'register'));
        Route::post('firechat/newroom', array($this, 'newroom'));
        Route::post('firechat/close', array($this, 'closesession'));

        Route::post('firechat/getform', array($this, 'getform'));
        Route::post('firechat/sendmail', array($this, 'sendmail'));

        Event::listen('bottom_contructor', array($this, 'popup'));
        Event::listen('logo_contructor', array($this, 'topbutton'));
        Event::listen('contact_col1_contructor', array($this, 'contactbutton'));
        Event::listen('contact_right_list', array($this, 'buttonlist'));
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
                    ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('function'), PersonLangModel::getField('last_name'))
                    ->orderBy(PersonLangModel::getField('first_name'))
                    ->where(PersonModel::getField('for_audience'), 1)
                    ->where(PersonLangModel::getField('lang_id'), \WebAPL\Language::getId())
                    ->get(),
            'session_exist' => false
        );

        if ($session_id) {
            $data['chat'] = \FireChatSession::find($session_id);
            if ($data['chat']) {
                if ($data['chat']->active) {
                    $data['session_exist'] = true;
                    $data['person'] = PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField('person_id'), '=', PersonModel::getField('id'))
                            ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('function'), PersonLangModel::getField('last_name'))
                            ->orderBy(PersonLangModel::getField('first_name'))
                            ->where(PersonModel::getField('for_audience'), 1)
                            ->where(\PersonModel::getField('id'), $data['chat']->person_id)
                            ->where(PersonLangModel::getField('lang_id'), \WebAPL\Language::getId())
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
                ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('function'), PersonLangModel::getField('last_name'))
                ->where(PersonModel::getField('for_audience'), 1)
                ->where(PersonModel::getField('id'), $person_id)
                ->where(PersonLangModel::getField('lang_id'), \WebAPL\Language::getId())
                ->first();
        if ($person) {

            $item = new \FireChatSession;
            $item->user_email = $email;
            $item->user_name = $name;
            $item->person_id = $person_id;
            $item->save();

            $photo = \Files::getfile('person_chat', $person->id);
            if ($photo) {
                $person['photo'] = url($photo->path);
            } else {
                $person['photo'] = url('apps/frontend/modules/firechat/assets/chat.jpg');
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
                    ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('function'), PersonLangModel::getField('last_name'))
                    ->orderBy(PersonLangModel::getField('first_name'))
                    ->where(PersonModel::getField('for_audience'), 1)
                    ->where(PersonLangModel::getField('lang_id'), \WebAPL\Language::getId())
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
                $person = \PersonLangModel::where('person_id', $chat->person_id)->where('lang_id', \WebAPL\Language::getId())->first();
                Template::viewModule($this->module_name, function () use ($data, $chat, $person) {
                    \Mail::send('views.email-mess', $data, function($message) use ($chat, $person) {
                        $message->from("noreply@{$_SERVER['SERVER_NAME']}", 'WebLPA');
                        $message->subject("Discutie on-line cu " . $person->first_name . " " . $person->last_name . " din " . date("Y-m-d H:i"));
                        $message->to($chat->user_email);
                    });
                });
            }
        }
    }
    
    public function buttonlist() {
        $data = array(
            'online' => Firechat::online()
        );

        echo Template::moduleView($this->module_name, 'views.chat-list-button', $data);
    }

}
