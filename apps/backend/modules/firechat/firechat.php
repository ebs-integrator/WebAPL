<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    FireBaseAuth,
    JWT,
    FireChatSession;

class Firechat extends \Core\APL\ExtensionController {

    protected $module_name = 'firechat';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('FireChatSession', 'FireBaseAuth'));

        Actions::get('firechat', array('before' => 'auth', array($this, 'view')));
        Actions::get('firechat/display', array('before' => 'auth', array($this, 'display')));
        Actions::post('firechat/closeroom', array('before' => 'auth', array($this, 'closeroom')));
        Actions::post('firechat/audience', array('before' => 'auth', array($this, 'audience')));
        Actions::post('firechat/sendmail', array('before' => 'auth', array($this, 'sendmail')));
        
        Actions::register('construct_left_menu', array($this, 'left_menu_item'));

        $this->layout = Template::mainLayout();
    }

    public function view() {
        \User::onlyHas('chat-view');

        $data = array(
            'person' => \PersonModel::where('user_id', \Auth::user()->id)->first(),
        );

        $this->layout->content = Template::moduleView($this->module_name, 'views.chat-form', $data);

        return $this->layout;
    }

    public function display() {
        \User::onlyHas('chat-view');

        $data = array(
            'person' => \PersonModel::where('user_id', \Auth::user()->id)->first(),
        );

        if ($data['person']) {

            $tokenGen = new FireBaseAuth("CNxpPpOaK5Bz7kofs7LaJtibgi7hqQALICdu96H5");
            $data['token'] = $tokenGen->createToken(array("uid" => "person-{$data['person']->id}"), array("admin" => True));

            $data['person_lang'] = $data['person']->langs()->where('lang_id', \Core\APL\Language::getId())->first();

            return Template::moduleView($this->module_name, 'views.chat-display', $data);
        } else {
            throw new Exception('Person not found');
        }
    }

    public function left_menu_item() {
        if (\User::has('chat-view')) {
            echo Template::moduleView($this->module_name, 'views.chat-left-menu');
        }
    }

    public function closeroom() {
        \User::onlyHas('chat-view');

        $roomId = \Input::get('roomId');
        $person_id = \Input::get('person_id');

        FireChatSession::where(array(
            'roomId' => $roomId,
            'person_id' => $person_id
        ))->update(array(
            'active' => 0
        ));

        return [];
    }

    public function audience() {
        $id = \Input::get('id');
        $for_audience = \Input::get('for_audience');

        if ($id) {
            $person = \PersonModel::find($id);
            if ($person) {
                $person->for_audience = $for_audience ? 1 : 0;
                $person->save();
            }
        }

        return [];
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
